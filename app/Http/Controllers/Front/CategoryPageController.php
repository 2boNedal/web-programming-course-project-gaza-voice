<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryPageController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $articles = Article::query()
            ->with(['category', 'tags'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->latest('id')
            ->paginate(9);

        return view('front.partials.category-page', [
            'category' => $category,
            'articles' => $articles,
            'currentCategorySlug' => $slug,
        ]);
    }

    public function gaza(): RedirectResponse
    {
        return redirect()->route('categories.show', $this->resolveLegacyCategorySlug(['غزة']));
    }

    public function israeliAffairs(): RedirectResponse
    {
        return redirect()->route('categories.show', $this->resolveLegacyCategorySlug([
            'شؤون إسرائيلية',
            'شؤون إسرائليلة',
        ]));
    }

    public function arabWorld(): RedirectResponse
    {
        return redirect()->route('categories.show', $this->resolveLegacyCategorySlug(['الوطن العربي']));
    }

    public function palestineNews(): RedirectResponse
    {
        return redirect()->route('categories.show', $this->resolveLegacyCategorySlug(['أخبار فلسطين']));
    }
    private function resolveLegacyCategorySlug(array $names): string
    {
        return Category::query()
            ->whereIn('name', $names)
            ->firstOrFail()
            ->slug;
    }
}
