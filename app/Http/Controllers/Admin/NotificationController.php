<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $admin = $request->user('admin');

        $notifications = $admin->notifications()
            ->latest()
            ->paginate(20);

        $unreadCount = $admin->unreadNotifications()->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $admin = $request->user('admin');

        $notificationModel = $admin->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        if (is_null($notificationModel->read_at)) {
            $notificationModel->markAsRead();
        }

        return redirect()
            ->back()
            ->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user('admin')
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return redirect()
            ->back()
            ->with('success', 'All notifications marked as read.');
    }
}
