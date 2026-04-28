<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class AdminNotificationService
{
    public function sendToActiveAdmins(Notification $notification): void
    {
        $admins = Admin::query()
            ->where('is_active', true)
            ->get();

        if ($admins->isEmpty()) {
            return;
        }

        NotificationFacade::send($admins, $notification);
    }
}
