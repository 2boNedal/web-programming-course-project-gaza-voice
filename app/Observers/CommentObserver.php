<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use App\Services\AdminNotificationService;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        $comment->loadMissing('article');

        app(AdminNotificationService::class)
            ->sendToActiveAdmins(new NewCommentNotification($comment));
    }
}
