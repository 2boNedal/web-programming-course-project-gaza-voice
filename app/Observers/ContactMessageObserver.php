<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Notifications\NewContactMessageNotification;
use App\Services\AdminNotificationService;

class ContactMessageObserver
{
    public function created(ContactMessage $contactMessage): void
    {
        app(AdminNotificationService::class)
            ->sendToActiveAdmins(new NewContactMessageNotification($contactMessage));
    }
}
