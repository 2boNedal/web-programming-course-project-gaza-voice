<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = DB::table('contact_messages')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function markRead(int $message): RedirectResponse
    {
        $exists = DB::table('contact_messages')->where('id', $message)->exists();

        abort_if(! $exists, 404);

        DB::table('contact_messages')
            ->where('id', $message)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Message marked as read.');
    }

    public function markUnread(int $message): RedirectResponse
    {
        $exists = DB::table('contact_messages')->where('id', $message)->exists();

        abort_if(! $exists, 404);

        DB::table('contact_messages')
            ->where('id', $message)
            ->update([
                'is_read' => false,
                'read_at' => null,
                'read_by_admin_id' => null,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Message marked as unread.');
    }

    public function destroy(int $message): RedirectResponse
    {
        $exists = DB::table('contact_messages')->where('id', $message)->exists();

        abort_if(! $exists, 404);

        DB::table('contact_messages')->where('id', $message)->delete();

        return back()->with('success', 'Message deleted permanently.');
    }
}
