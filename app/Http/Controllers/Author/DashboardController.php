<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $authorId = Auth::guard('author')->id();

        return view('author.dashboard', [
            'stats' => [
                [
                    'label' => 'My Articles',
                    'count' => Article::query()->where('author_id', $authorId)->count(),
                    'icon' => 'bi bi-file-earmark-text',
                    'color' => 'primary',
                    'route' => route('author.articles.index'),
                ],
                [
                    'label' => 'Draft Articles',
                    'count' => Article::query()
                        ->where('author_id', $authorId)
                        ->where('status', 'draft')
                        ->count(),
                    'icon' => 'bi bi-pencil-square',
                    'color' => 'secondary',
                    'route' => route('author.articles.index'),
                ],
                [
                    'label' => 'Pending Review',
                    'count' => Article::query()
                        ->where('author_id', $authorId)
                        ->where('status', 'pending_review')
                        ->count(),
                    'icon' => 'bi bi-hourglass-split',
                    'color' => 'warning',
                    'route' => route('author.articles.index'),
                ],
                [
                    'label' => 'Needs Revision',
                    'count' => Article::query()
                        ->where('author_id', $authorId)
                        ->where('status', 'needs_revision')
                        ->count(),
                    'icon' => 'bi bi-arrow-repeat',
                    'color' => 'danger',
                    'route' => route('author.articles.index'),
                ],
                [
                    'label' => 'Published Articles',
                    'count' => Article::query()
                        ->where('author_id', $authorId)
                        ->where('status', 'published')
                        ->count(),
                    'icon' => 'bi bi-check-circle',
                    'color' => 'success',
                    'route' => route('author.articles.index'),
                ],
                [
                    'label' => 'Comments on My Articles',
                    'count' => Comment::query()
                        ->whereHas('article', fn ($query) => $query->where('author_id', $authorId))
                        ->count(),
                    'icon' => 'bi bi-chat-left-text',
                    'color' => 'info',
                    'route' => route('author.comments.index'),
                ],
            ],
        ]);
    }
}
