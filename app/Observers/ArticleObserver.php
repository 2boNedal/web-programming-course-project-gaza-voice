<?php

namespace App\Observers;

use App\Models\Article;
use App\Notifications\ArticleSubmittedForReviewNotification;
use App\Services\AdminNotificationService;
use Illuminate\Support\Str;

class ArticleObserver
{
    private const REVIEW_STATUSES = [
        'submitted',
        'for_review',
        'under_review',
        'pending_review',
        'in_review',
    ];

    public function created(Article $article): void
    {
        if ($this->wasSubmittedForReview($article)) {
            $this->notify($article);
        }
    }

    public function updated(Article $article): void
    {
        if ($this->wasSubmittedForReview($article)) {
            $this->notify($article);
        }
    }

    private function wasSubmittedForReview(Article $article): bool
    {
        $currentStatus = Str::lower((string) $article->status);
        $originalStatus = Str::lower((string) $article->getOriginal('status'));

        $submittedAtSetNow = filled($article->submitted_at)
            && (
                $article->wasRecentlyCreated
                || ($article->wasChanged('submitted_at') && blank($article->getOriginal('submitted_at')))
            );

        $statusEnteredReview = in_array($currentStatus, self::REVIEW_STATUSES, true)
            && (
                $article->wasRecentlyCreated
                || ($article->wasChanged('status') && !in_array($originalStatus, self::REVIEW_STATUSES, true))
            );

        return $submittedAtSetNow || $statusEnteredReview;
    }

    private function notify(Article $article): void
    {
        $article->loadMissing('author');

        app(AdminNotificationService::class)
            ->sendToActiveAdmins(new ArticleSubmittedForReviewNotification($article));
    }
}
