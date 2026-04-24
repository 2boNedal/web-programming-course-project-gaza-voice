<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicCategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = DB::table('categories')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->first();

        abort_if(! $category, 404);

        $articles = DB::table('articles')
            ->where('category_id', $category->id)
            ->whereNull('deleted_at')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

        $articleTags = $this->loadArticleTags($articles->getCollection()->pluck('id'));

        return view('front.category-page', [
            'category' => $category,
            'articles' => $articles,
            'articleTags' => $articleTags,
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

    private function loadArticleTags(Collection $articleIds): array
    {
        if ($articleIds->isEmpty()) {
            return [];
        }

        $rows = DB::table('article_tag')
            ->join('tags', 'article_tag.tag_id', '=', 'tags.id')
            ->whereIn('article_tag.article_id', $articleIds)
            ->orderBy('tags.name')
            ->select('article_tag.article_id', 'tags.name')
            ->get();

        $grouped = [];

        foreach ($rows as $row) {
            $grouped[$row->article_id][] = $row->name;
        }

        return $grouped;
    }
}
