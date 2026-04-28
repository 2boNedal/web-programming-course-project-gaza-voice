<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Author\ArticleController as AuthorArticleController;
use App\Http\Controllers\Author\CommentController as AuthorCommentController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Front\ArticlePageController;
use App\Http\Controllers\Front\AuthorPageController;
use App\Http\Controllers\Front\CategoryPageController;
use App\Http\Controllers\Front\SearchController;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $publishedArticles = Article::query()
        ->with('category')
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->latest('id');

    $topArticles = (clone $publishedArticles)->take(5)->get();
    $featuredArticle = $topArticles->first();
    $sideArticles = $topArticles->slice(1)->values();
    $olderArticles = (clone $publishedArticles)
        ->whereNotIn('id', $topArticles->pluck('id'))
        ->paginate(9);

    return view('front.home', [
        'banners' => Banner::orderByDesc('id')->get(),
        'featuredArticle' => $featuredArticle,
        'sideArticles' => $sideArticles,
        'olderArticles' => $olderArticles,
        'availableTags' => Tag::query()->orderBy('name')->get(['id', 'name']),
    ]);
});
Route::get('/articles/{slug}', [ArticlePageController::class, 'show'])->name('articles.show');
Route::get('/authors/{id}', [AuthorPageController::class, 'show'])->name('authors.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::prefix('admin')->middleware(['dashboard.guard:admin', 'auth:admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/trashed', [AdminArticleController::class, 'trashed'])->name('articles.trashed');
    Route::patch('/articles/{id}/trash/restore', [AdminArticleController::class, 'restoreFromTrash'])->name('articles.trash.restore');
    Route::delete('/articles/{id}/trash/force', [AdminArticleController::class, 'forceDeleteFromTrash'])->name('articles.trash.force');
    Route::get('/articles/{article}', [AdminArticleController::class, 'show'])->name('articles.show');
    Route::patch('/articles/{article}/publish', [AdminArticleController::class, 'publish'])->name('articles.publish');
    Route::patch('/articles/{article}/needs-revision', [AdminArticleController::class, 'markNeedsRevision'])->name('articles.needs-revision');
    Route::patch('/articles/{article}/archive', [AdminArticleController::class, 'archive'])->name('articles.archive');
    Route::patch('/articles/{article}/restore-admin-draft', [AdminArticleController::class, 'restoreAdminDraft'])->name('articles.restore-admin-draft');
    Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
    Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::patch('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    Route::patch('/admins/{admin}/toggle-active', [AdminController::class, 'toggleActive'])->name('admins.toggle-active');

    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/trashed', [AuthorController::class, 'trashed'])->name('authors.trashed');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::patch('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::patch('/authors/{author}/password', [AuthorController::class, 'resetPassword'])->name('authors.password');
    Route::patch('/authors/{author}/toggle-active', [AuthorController::class, 'toggleActive'])->name('authors.toggle-active');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::patch('/authors/{id}/restore', [AuthorController::class, 'restore'])->name('authors.restore');
    Route::delete('/authors/{id}/force', [AuthorController::class, 'forceDelete'])->name('authors.force');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{id}/force', [CategoryController::class, 'forceDelete'])->name('categories.force');

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::patch('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::patch('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::patch('/contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.read');
    Route::patch('/contact-messages/{contactMessage}/unread', [ContactMessageController::class, 'markAsUnread'])->name('contact-messages.unread');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});

Route::prefix('author')->middleware(['dashboard.guard:author', 'auth:author'])->group(function () {
    Route::get('/', [AuthorDashboardController::class, 'index'])->name('author.dashboard');

    Route::get('/articles', [AuthorArticleController::class, 'index'])->name('author.articles.index');
    Route::get('/articles/create', [AuthorArticleController::class, 'create'])->name('author.articles.create');

    Route::get('/articles/trashed', [AuthorArticleController::class, 'trashed'])->name('author.articles.trashed');
    Route::patch('/articles/{id}/trash/restore', [AuthorArticleController::class, 'restoreFromTrash'])->name('author.articles.trash.restore');
    Route::delete('/articles/{id}/trash/force', [AuthorArticleController::class, 'forceDeleteFromTrash'])->name('author.articles.trash.force');

    Route::post('/articles', [AuthorArticleController::class, 'store'])->name('author.articles.store');
    Route::get('/articles/{article}/edit', [AuthorArticleController::class, 'edit'])->name('author.articles.edit');
    Route::patch('/articles/{article}', [AuthorArticleController::class, 'update'])->name('author.articles.update');
    Route::patch('/articles/{article}/save-draft', [AuthorArticleController::class, 'saveAsDraft'])->name('author.articles.save-draft');
    Route::patch('/articles/{article}/submit-review', [AuthorArticleController::class, 'submitForReview'])->name('author.articles.submit-review');
    Route::delete('/articles/{article}', [AuthorArticleController::class, 'destroy'])->name('author.articles.destroy');

    Route::get('/profile', [ProfileController::class, 'show'])->name('author.profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('author.profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('author.profile.password');

    Route::get('/comments', [AuthorCommentController::class, 'index'])->name('author.comments.index');
    Route::delete('/comments/{comment}', [AuthorCommentController::class, 'destroy'])->name('author.comments.destroy');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search-results', [SearchController::class, 'redirectLegacy'])->name('search.legacy');
Route::get('/tags/suggest', [SearchController::class, 'suggest'])->name('tags.suggest');
Route::get('/categories/{slug}', [CategoryPageController::class, 'show'])->name('categories.show');
Route::get('/gaza', [CategoryPageController::class, 'gaza'])->name('front.categories.gaza');
Route::get('/israeli-affairs', [CategoryPageController::class, 'israeliAffairs'])->name('front.categories.israeli-affairs');
Route::get('/arab-world', [CategoryPageController::class, 'arabWorld'])->name('front.categories.arab-world');
Route::get('/palestine-news', [CategoryPageController::class, 'palestineNews'])->name('front.categories.palestine-news');
