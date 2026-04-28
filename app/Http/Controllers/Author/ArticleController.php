<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreArticleRequest;
use App\Http\Requests\Author\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->with(['category', 'tags'])
            ->where('author_id', Auth::guard('author')->id())
            ->latest()
            ->get();

        return view('author.articles.index', [
            'publishedArticles' => $articles->where('status', 'published')->values(),
            'pendingReviewArticles' => $articles->where('status', 'pending_review')->values(),
            'needsRevisionArticles' => $articles->where('status', 'needs_revision')->values(),
            'draftArticles' => $articles->where('status', 'draft')->values(),
        ]);
    }

    public function create(): View
    {
        return view('author.articles.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function trashed(): View
    {
        $trashedArticles = Article::onlyTrashed()
            ->with(['category', 'tags'])
            ->where('author_id', Auth::guard('author')->id())
            ->where('status', 'draft')
            ->where('draft_origin', 'author')
            ->latest('deleted_at')
            ->get();

        return view('author.articles.trashed', compact('trashedArticles'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $coverImage = $request->file('cover_image');
        $originalName = basename($coverImage->getClientOriginalName());

        $article = Article::create([
            'author_id' => Auth::guard('author')->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => $validated['body'],
            'status' => 'draft',
            'draft_origin' => 'author',
            'cover_image' => $coverImage->storeAs('articles/covers', $originalName, 'public'),
        ]);

        $article->tags()->sync($validated['tags']);

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Article draft created successfully.');
    }

    public function edit(Article $article): View
    {
        $this->ensureEditable($article);

        $article->load('tags');

        return view('author.articles.edit', [
            'article' => $article,
            'categories' => Category::query()->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $this->ensureEditable($article);

        $validated = $request->validated();

        $payload = [
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => $validated['body'],
        ];

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $originalName = basename($coverImage->getClientOriginalName());
            $payload['cover_image'] = $coverImage->storeAs('articles/covers', $originalName, 'public');
        }

        $article->update($payload);
        $article->tags()->sync($validated['tags']);

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function submitForReview(Article $article): RedirectResponse
    {
        $this->ensureSubmittable($article);

        $article->update([
            'status' => 'pending_review',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Article sent for review successfully.');
    }

    public function saveAsDraft(Article $article): RedirectResponse
    {
        $this->ensureSaveAsDraftable($article);

        $article->update([
            'status' => 'draft',
            'submitted_at' => null,
        ]);

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Article moved back to draft successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->ensureDeletable($article);

        $article->delete();

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Article draft deleted successfully.');
    }

    public function restoreFromTrash(int $id): RedirectResponse
    {
        $article = $this->findAuthorTrashedDraft($id);
        $article->restore();
        $article->update([
            'status' => 'draft',
            'submitted_at' => null,
        ]);

        return redirect()
            ->route('author.articles.trashed')
            ->with('success', 'Article restored successfully.');
    }

    public function forceDeleteFromTrash(int $id): RedirectResponse
    {
        $article = $this->findAuthorTrashedDraft($id);
        $article->forceDelete();

        return redirect()
            ->route('author.articles.trashed')
            ->with('success', 'Article permanently deleted successfully.');
    }

    private function ensureEditable(Article $article): void
    {
        abort_unless(
            $article->author_id === Auth::guard('author')->id()
                && in_array($article->status, ['draft', 'needs_revision'], true)
                && $article->draft_origin === 'author',
            403
        );
    }

    private function ensureDeletable(Article $article): void
    {
        abort_unless(
            $article->author_id === Auth::guard('author')->id()
                && $article->status === 'draft'
                && $article->draft_origin === 'author',
            403
        );
    }

    private function ensureSubmittable(Article $article): void
    {
        abort_unless(
            $article->author_id === Auth::guard('author')->id()
                && in_array($article->status, ['draft', 'needs_revision'], true)
                && $article->draft_origin === 'author',
            403
        );
    }

    private function ensureSaveAsDraftable(Article $article): void
    {
        abort_unless(
            $article->author_id === Auth::guard('author')->id()
                && $article->status === 'needs_revision'
                && $article->draft_origin === 'author',
            403
        );
    }

    private function findAuthorTrashedDraft(int $id): Article
    {
        return Article::onlyTrashed()
            ->where('id', $id)
            ->where('author_id', Auth::guard('author')->id())
            ->where('status', 'draft')
            ->where('draft_origin', 'author')
            ->firstOrFail();
    }
}
