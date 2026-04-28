<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::orderByDesc('id')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function store(StoreBannerRequest $request): RedirectResponse
    {
        Banner::create([
            'title' => $request->validated('title'),
            'created_by_admin_id' => Auth::guard('admin')->id(),
            'updated_by_admin_id' => Auth::guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        $banner->update([
            'title' => $request->validated('title'),
            'updated_by_admin_id' => Auth::guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }
}

