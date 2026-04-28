<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->with(['author', 'category', 'tags'])
            ->latest()
            ->get();

        return view('admin.articles.index', [
            'publishedArticles' => $articles->where('status', 'published')->values(),
            'pendingReviewArticles' => $articles->where('status', 'pending_review')->values(),
            'needsRevisionArticles' => $articles->where('status', 'needs_revision')->values(),
            'draftArticles' => $articles->where('status', 'draft')->values(),
        ]);
    }

    public function show(Article $article): View
    {
        $article->load(['author', 'category', 'tags']);

        return view('admin.articles.show', compact('article'));
    }

    public function publish(Article $article): RedirectResponse
    {
        abort_unless($article->status === 'pending_review', 403);

        $article->update([
            'status' => 'published',
            'published_at' => now(),
            'restore_to_status' => null,
            'restore_published_at' => null,
            'archived_by_admin_id' => null,
            'archived_at' => null,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article published successfully.');
    }

    public function markNeedsRevision(Article $article): RedirectResponse
    {
        abort_unless($article->status === 'pending_review', 403);

        $article->update([
            'status' => 'needs_revision',
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article returned for revision successfully.');
    }

    public function archive(Article $article): RedirectResponse
    {
        abort_unless($article->status === 'published', 403);

        $article->update([
            'status' => 'draft',
            'draft_origin' => 'admin',
            'restore_to_status' => 'published',
            'restore_published_at' => $article->published_at,
            'published_at' => null,
            'archived_by_admin_id' => Auth::guard('admin')->id(),
            'archived_at' => now(),
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Published article archived into admin draft successfully.');
    }

    public function restoreAdminDraft(Article $article): RedirectResponse
    {
        abort_unless(
            $article->status === 'draft'
                && $article->draft_origin === 'admin'
                && filled($article->restore_to_status),
            403
        );

        $article->update([
            'status' => $article->restore_to_status,
            'published_at' => $article->restore_published_at,
            'draft_origin' => 'author',
            'restore_to_status' => null,
            'restore_published_at' => null,
            'archived_by_admin_id' => null,
            'archived_at' => null,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Admin draft restored successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        abort_unless($article->status === 'draft', 403);

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Draft article moved to trash successfully.');
    }

    public function trashed(): View
    {
        $articles = Article::onlyTrashed()
            ->with(['author', 'category', 'tags'])
            ->latest('deleted_at')
            ->get();

        return view('admin.articles.trashed', compact('articles'));
    }

    public function restoreFromTrash(int $id): RedirectResponse
    {
        $article = Article::onlyTrashed()
            ->where('id', $id)
            ->where('status', 'draft')
            ->firstOrFail();

        $article->restore();
        $article->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return redirect()
            ->route('admin.articles.trashed')
            ->with('success', 'Article restored from trash successfully.');
    }

    public function forceDeleteFromTrash(int $id): RedirectResponse
    {
        $article = Article::onlyTrashed()
            ->where('id', $id)
            ->where('status', 'draft')
            ->firstOrFail();

        $article->forceDelete();

        return redirect()
            ->route('admin.articles.trashed')
            ->with('success', 'Article permanently deleted successfully.');
    }
}
