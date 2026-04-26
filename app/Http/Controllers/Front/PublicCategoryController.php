<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicCategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->with('tags')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('front.category-page', [
            'category' => $category,
            'articles' => $articles,
            'activeNavSlug' => $slug,
        ]);
    }

    public function gaza(): RedirectResponse
    {
        return redirect()->route('front.categories.show', ['slug' => 'gaza']);
    }

    public function israeliAffairs(): RedirectResponse
    {
        return redirect()->route('front.categories.show', ['slug' => 'israeli-affairs']);
    }

    public function arabWorld(): RedirectResponse
    {
        return redirect()->route('front.categories.show', ['slug' => 'arab-world']);
    }

    public function palestineNews(): RedirectResponse
    {
        return redirect()->route('front.categories.show', ['slug' => 'palestine-news']);
    }
}

