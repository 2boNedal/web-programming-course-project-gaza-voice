<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

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
});

Route::view('/author', 'author.dashboard');
Route::view('/', 'front.home');
Route::view('/login', 'front.login');
Route::view('/contact', 'front.contact');
Route::view('/gaza', 'front.gaza');
Route::view('/israeli-affairs', 'front.israeli-affairs');
Route::view('/arab-world', 'front.arab-world');
Route::view('/palestine-news', 'front.palestine-news');
Route::view('/search-results', 'front.search-results');
