<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Comment $comment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event' => 'comment_posted',
            'title' => 'New comment posted',
            'message' => sprintf(
                '%s posted a new comment on "%s".',
                $this->comment->guest_name,
                $this->comment->article?->title ?? 'an article'
            ),
            'details' => Str::limit($this->comment->content, 120),
            'resource_id' => $this->comment->id,
            'resource_type' => 'comment',
        ];
    }
}
