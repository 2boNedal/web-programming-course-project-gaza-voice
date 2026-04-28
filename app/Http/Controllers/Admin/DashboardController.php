<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $currentAdmin = Auth::guard('admin')->user();

        return view('admin.dashboard', [
            'stats' => [
                [
                    'label' => 'Articles',
                    'count' => Article::query()->count(),
                    'icon' => 'bi bi-file-earmark-text',
                    'color' => 'primary',
                    'route' => route('admin.articles.index'),
                ],
                [
                    'label' => 'Categories',
                    'count' => Category::query()->count(),
                    'icon' => 'bi bi-folder',
                    'color' => 'success',
                    'route' => route('admin.categories.index'),
                ],
                [
                    'label' => 'Tags',
                    'count' => Tag::query()->count(),
                    'icon' => 'bi bi-tags',
                    'color' => 'warning',
                    'route' => route('admin.tags.index'),
                ],
                [
                    'label' => 'Authors',
                    'count' => Author::query()->count(),
                    'icon' => 'bi bi-people',
                    'color' => 'info',
                    'route' => route('admin.authors.index'),
                ],
                [
                    'label' => 'Comments',
                    'count' => Comment::query()->count(),
                    'icon' => 'bi bi-chat-left-text',
                    'color' => 'danger',
                    'route' => route('admin.comments.index'),
                ],
                [
                    'label' => 'Contact Messages',
                    'count' => ContactMessage::query()->count(),
                    'icon' => 'bi bi-envelope',
                    'color' => 'secondary',
                    'route' => route('admin.contact-messages.index'),
                ],
                [
                    'label' => 'Breaking News',
                    'count' => Banner::query()->count(),
                    'icon' => 'bi bi-lightning-charge',
                    'color' => 'dark',
                    'route' => route('admin.banners.index'),
                ],
                [
                    'label' => 'Notifications',
                    'count' => $currentAdmin?->notifications()->count() ?? 0,
                    'icon' => 'bi bi-bell',
                    'color' => 'warning',
                    'route' => route('admin.notifications.index'),
                    'meta' => 'Unread: ' . ($currentAdmin?->unreadNotifications()->count() ?? 0),
                ],
            ],
        ]);
    }
}
