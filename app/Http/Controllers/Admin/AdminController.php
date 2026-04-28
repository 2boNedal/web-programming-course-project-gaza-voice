<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $admins = Admin::orderByDesc('id')->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $originalName = basename($file->getClientOriginalName());
            $data['avatar'] = $file->storeAs('avatars', $originalName, 'public');
        }

        $admin = Admin::create($data);

        return redirect()
            ->route('admin.admins.show', $admin)
            ->with('success', 'Admin account created successfully.');
    }

    public function show(Admin $admin): View
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(Admin $admin): View
    {
        $this->ensureSelfEditable($admin);

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        $this->ensureSelfEditable($admin);

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $originalName = basename($file->getClientOriginalName());
            $data['avatar'] = $file->storeAs('avatars', $originalName, 'public');
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()
            ->route('admin.admins.show', $admin)
            ->with('success', 'Admin account updated successfully.');
    }

    public function toggleActive(Admin $admin): RedirectResponse
    {
        $admin->is_active = !$admin->is_active;
        $admin->save();

        return redirect()
            ->back()
            ->with('success', 'Admin status updated successfully.');
    }

    private function ensureSelfEditable(Admin $admin): void
    {
        abort_unless(Auth::guard('admin')->id() === $admin->id, 403);
    }
}
