<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        DB::table('contact_messages')->insert([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'is_read' => false,
            'read_at' => null,
            'read_by_admin_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Your message has been sent successfully.');
    }
}
