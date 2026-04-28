<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Observers\ArticleObserver;
use App\Observers\CommentObserver;
use App\Observers\ContactMessageObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Article::observe(ArticleObserver::class);
        Comment::observe(CommentObserver::class);
        ContactMessage::observe(ContactMessageObserver::class);

        View::composer(['front.*', 'front.*.*'], function ($view) {
            $view->with('navbarCategories', Category::query()
                ->orderBy('id')
                ->get(['id', 'name', 'slug']));
        });
    }
}
