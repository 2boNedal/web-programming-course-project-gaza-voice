<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\UpdateAuthorProfileRequest;
use App\Http\Requests\Author\UpdateAuthorPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $author = Auth::guard('author')->user();

        return view('author.profile', compact('author'));
    }

    public function update(UpdateAuthorProfileRequest $request): RedirectResponse
    {
        $author = Auth::guard('author')->user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = basename($file->getClientOriginalName());
            $data['profile_image'] = $file->storeAs('authors/profile-images', $originalName, 'public');
        }

        unset($data['image']);
        $author->update($data);

        return redirect()
            ->route('author.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdateAuthorPasswordRequest $request): RedirectResponse
    {
        $author = Auth::guard('author')->user();

        $author->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()
            ->route('author.profile.show')
            ->with('success', 'Password updated successfully.');
    }
}
