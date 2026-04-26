<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function submit(Article $article)
    {
        if ($article->draft_origin !== 'author') {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($article->status, ['draft', 'needs_revision'])) {
            abort(403, 'Article must be draft or needs_revision to be submitted.');
        }

        $article->update([
            'status' => 'pending_review',
            'submitted_at' => now()
        ]);

        return redirect()->back()->with('success', 'Article submitted for review.');
    }

    public function destroy(Article $article)
    {
        if ($article->status !== 'draft') {
            abort(403, 'Only draft articles can be deleted.');
        }

        if ($article->draft_origin !== 'author') {
            abort(403, 'Unauthorized action.');
        }

        $article->delete();

        return redirect()->back()->with('success', 'Article moved to trash.');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()
            ->where('draft_origin', 'author')
            ->get();

        return view('author.articles.trashed', compact('articles'));
    }

    public function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        if ($article->draft_origin !== 'author') {
            abort(403, 'Unauthorized action.');
        }

        $article->restore();
        
        // Ensure it returns to draft status when restored from trash by author
        $article->update(['status' => 'draft']);

        return redirect()->back()->with('success', 'Article restored to draft.');
    }

    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        if ($article->draft_origin !== 'author') {
            abort(403, 'Unauthorized action.');
        }

        $article->forceDelete();

        return redirect()->back()->with('success', 'Article permanently deleted.');
    }
}
