<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $comments = Comment::query()
            ->with('article')
            ->whereHas('article', function ($query) use ($request): void {
                $query->where('author_id', $request->user('author')->id);
            })
            ->latest()
            ->get();

        return view('author.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->loadMissing('article');

        abort_unless(
            $comment->article && $comment->article->author_id === Auth::guard('author')->id(),
            403
        );

        $comment->delete();

        return redirect()
            ->route('author.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}
