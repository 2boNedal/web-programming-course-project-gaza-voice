<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/admin', 'admin.dashboard');
Route::view('/author', 'author.dashboard');
Route::view('/', 'front.home');
Route::view('/login', 'front.login');
Route::view('/contact', 'front.contact');
Route::view('/gaza', 'front.gaza');
Route::view('/israeli-affairs', 'front.israeli-affairs');
Route::view('/arab-world', 'front.arab-world');
Route::view('/palestine-news', 'front.palestine-news');
Route::view('/search-results', 'front.search-results');


