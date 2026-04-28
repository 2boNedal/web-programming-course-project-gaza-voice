<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'article_id' => $validated['article_id'],
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'content' => $validated['content'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return redirect()
            ->route('articles.show', ['slug' => $comment->article->slug])
            ->withFragment('comments')
            ->with('success', 'Comment posted successfully.');
    }
}
