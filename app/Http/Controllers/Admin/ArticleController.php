<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'published');
        
        $articles = Article::where('status', $status)
            ->latest()
            ->paginate(15);
            
        return view('admin.articles.index', compact('articles', 'status'));
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function publish(Article $article)
    {
        if ($article->status !== 'pending_review') {
            abort(403, 'Only pending_review articles can be published.');
        }

        $article->update([
            'status' => 'published',
            'published_at' => now(),
            'restore_to_status' => null,
            'restore_published_at' => null,
        ]);

        return redirect()->back()->with('success', 'Article published.');
    }

    public function needsRevision(Article $article)
    {
        if ($article->status !== 'pending_review') {
            abort(403, 'Only pending_review articles can be marked as needs_revision.');
        }

        $article->update([
            'status' => 'needs_revision'
        ]);

        return redirect()->back()->with('success', 'Article marked as needs revision.');
    }

    public function archive(Article $article)
    {
        if ($article->status !== 'published') {
            abort(403, 'Only published articles can be archived.');
        }

        $article->update([
            'status' => 'draft',
            'draft_origin' => 'admin',
            'restore_to_status' => 'published',
            'restore_published_at' => $article->published_at,
            'archived_at' => now(),
            'archived_by_admin_id' => auth()->id() ?? 1, // fallback to 1 if not logged in
            'published_at' => null,
        ]);

        return redirect()->back()->with('success', 'Article archived as admin-draft.');
    }

    public function restoreDraft(Article $article)
    {
        if ($article->draft_origin !== 'admin') {
            abort(403, 'Can only restore admin drafts.');
        }

        $status = $article->restore_to_status ?? 'published';
        
        $article->update([
            'status' => $status,
            'draft_origin' => 'author',
            'published_at' => $article->restore_published_at,
            'restore_to_status' => null,
            'restore_published_at' => null,
            'archived_at' => null,
            'archived_by_admin_id' => null,
        ]);

        return redirect()->back()->with('success', 'Article restored from admin-draft.');
    }

    public function destroy(Article $article)
    {
        if ($article->status !== 'draft') {
            abort(403, 'Only draft articles can be soft deleted.');
        }

        $article->delete();

        return redirect()->back()->with('success', 'Article soft deleted.');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->paginate(15);
        return view('admin.articles.trashed', compact('articles'));
    }

    public function restoreTrash($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        
        $article->restore();
        $article->update(['status' => 'draft']);

        return redirect()->back()->with('success', 'Article restored to draft.');
    }

    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $article->forceDelete();

        return redirect()->back()->with('success', 'Article permanently deleted.');
    }
}
