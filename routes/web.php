<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Front\PublicCategoryController;
use App\Http\Controllers\Front\TagSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\ArticleController;


Route::prefix('author')->name('author.')->group(function () {

    Route::get('/', function () {
        return view('author.dashboard');
    })->name('dashboard');
Route::resource('articles', ArticleController::class)->except(['show']);
});


Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');

    Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::patch('categories/{category}/restore', [CategoryController::class, 'restore'])
        ->whereNumber('category')
        ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
        ->whereNumber('category')
        ->name('categories.force-delete');
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::resource('tags', TagController::class)->except(['show']);

    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::patch('contact-messages/{message}/read', [ContactMessageController::class, 'markRead'])
        ->whereNumber('message')
        ->name('contact-messages.read');
    Route::patch('contact-messages/{message}/unread', [ContactMessageController::class, 'markUnread'])
        ->whereNumber('message')
        ->name('contact-messages.unread');
    Route::delete('contact-messages/{message}', [ContactMessageController::class, 'destroy'])
        ->whereNumber('message')
        ->name('contact-messages.destroy');
});







Route::view('/login', 'front.login');
Route::view('/contact', 'front.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/categories/{slug}', [PublicCategoryController::class, 'show'])->name('front.categories.show');
Route::get('/gaza', [PublicCategoryController::class, 'gaza']);
Route::get('/israeli-affairs', [PublicCategoryController::class, 'israeliAffairs']);
Route::get('/arab-world', [PublicCategoryController::class, 'arabWorld']);
Route::get('/palestine-news', [PublicCategoryController::class, 'palestineNews']);

Route::get('/search', [TagSearchController::class, 'search'])->name('front.search');
Route::get('/search-results', [TagSearchController::class, 'search']);
Route::get('/tags/suggest', [TagSearchController::class, 'suggest'])->name('front.tags.suggest');
