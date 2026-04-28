<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function create(): View
    {
        return view('front.contact');
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->route('contact.create')
            ->with('success', 'Your message has been sent successfully.');
    }

    public function index(): View
    {
        $contactMessages = ContactMessage::query()
            ->latest()
            ->get();

        return view('admin.contact-messages.index', compact('contactMessages'));
    }

    public function markAsRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'is_read' => true,
            'read_at' => now(),
            'read_by_admin_id' => Auth::guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Contact message marked as read.');
    }

    public function markAsUnread(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'is_read' => false,
            'read_at' => null,
            'read_by_admin_id' => null,
        ]);

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Contact message marked as unread.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
