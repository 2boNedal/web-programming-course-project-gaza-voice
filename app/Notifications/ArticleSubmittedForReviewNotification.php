<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ArticleSubmittedForReviewNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Article $article)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event' => 'article_submitted_for_review',
            'title' => 'Article submitted for review',
            'message' => sprintf(
                '"%s" was sent for review by %s.',
                $this->article->title,
                $this->article->author?->name ?? 'an author'
            ),
            'details' => 'Review this article from the admin dashboard.',
            'resource_id' => $this->article->id,
            'resource_type' => 'article',
        ];
    }
}
