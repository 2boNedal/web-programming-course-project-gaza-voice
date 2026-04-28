<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetAuthorPasswordRequest;
use App\Http\Requests\Admin\StoreAuthorRequest;
use App\Http\Requests\Admin\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        $authors = Author::orderByDesc('id')->get();

        return view('admin.authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('admin.authors.create');
    }

    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $file = $request->file('image');
        $originalName = basename($file->getClientOriginalName());
        $data['profile_image'] = $file->storeAs('authors/profile-images', $originalName, 'public');
        $data['created_by_admin_id'] = Auth::guard('admin')->id();
        unset($data['image']);

        $author = Author::create($data);

        return redirect()
            ->route('admin.authors.show', $author)
            ->with('success', 'Author created successfully.');
    }

    public function show(Author $author): View
    {
        return view('admin.authors.show', compact('author'));
    }

    public function edit(Author $author): View
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = basename($file->getClientOriginalName());
            $data['profile_image'] = $file->storeAs('authors/profile-images', $originalName, 'public');
        }

        unset($data['image']);
        $author->update($data);

        return redirect()
            ->route('admin.authors.show', $author)
            ->with('success', 'Author updated successfully.');
    }

    public function resetPassword(ResetAuthorPasswordRequest $request, Author $author): RedirectResponse
    {
        $author->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()
            ->route('admin.authors.show', $author)
            ->with('success', 'Author password reset successfully.');
    }

    public function toggleActive(Author $author): RedirectResponse
    {
        $author->is_active = !$author->is_active;
        $author->save();

        return redirect()
            ->back()
            ->with('success', 'Author status updated successfully.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author moved to trash successfully.');
    }

    public function trashed(): View
    {
        $authors = Author::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('admin.authors.trashed', compact('authors'));
    }

    public function restore(int $id): RedirectResponse
    {
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->restore();

        return redirect()
            ->route('admin.authors.trashed')
            ->with('success', 'Author restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->forceDelete();

        return redirect()
            ->route('admin.authors.trashed')
            ->with('success', 'Author permanently deleted successfully.');
    }
}
