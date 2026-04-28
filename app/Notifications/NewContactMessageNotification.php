<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly ContactMessage $contactMessage)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event' => 'contact_message_submitted',
            'title' => 'New contact message submitted',
            'message' => sprintf(
                '%s sent a new contact message: "%s".',
                $this->contactMessage->name,
                $this->contactMessage->subject
            ),
            'details' => Str::limit($this->contactMessage->message, 120),
            'resource_id' => $this->contactMessage->id,
            'resource_type' => 'contact_message',
        ];
    }
}
