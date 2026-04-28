<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use Illuminate\View\View;

class ArticlePageController extends Controller
{
    public function show(string $slug): View
    {
        $article = Article::query()
            ->with([
                'author',
                'tags',
                'comments' => fn ($query) => $query->latest(),
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $currentTagIds = $article->tags->pluck('id')->all();

        $relatedArticlesQuery = Article::query()
            ->with([
                'category:id,name',
                'tags:id,name',
            ])
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $sameCategoryArticles = filled($article->category_id)
            ? (clone $relatedArticlesQuery)
                ->where('category_id', $article->category_id)
                ->latest('published_at')
                ->latest('id')
                ->take(4)
                ->get()
            : collect();

        $remainingSlots = 4 - $sameCategoryArticles->count();

        $tagFallbackArticles = $remainingSlots > 0 && $currentTagIds !== []
            ? (clone $relatedArticlesQuery)
                ->whereNotIn('id', $sameCategoryArticles->pluck('id'))
                ->whereHas('tags', fn ($query) => $query->whereIn('tags.id', $currentTagIds))
                ->latest('published_at')
                ->latest('id')
                ->take($remainingSlots)
                ->get()
            : collect();

        $relatedArticles = $sameCategoryArticles
            ->map(function (Article $relatedArticle) {
                $relatedArticle->setAttribute('related_badge_basis', 'category');
                $relatedArticle->setAttribute('related_badge_label', (string) optional($relatedArticle->category)->name);

                return $relatedArticle;
            })
            ->concat(
                $tagFallbackArticles->map(function (Article $relatedArticle) use ($currentTagIds) {
                    $matchingTag = $relatedArticle->tags->first(
                        fn ($tag) => in_array($tag->id, $currentTagIds, true)
                    );

                    $relatedArticle->setAttribute('related_badge_basis', 'tag');
                    $relatedArticle->setAttribute('related_badge_label', (string) optional($matchingTag)->name);

                    return $relatedArticle;
                })
            )
            ->take(4)
            ->values();

        return view('front.articles.show', [
            'article' => $article,
            'comments' => $article->comments,
            'relatedArticles' => $relatedArticles,
            'banners' => Banner::query()->orderByDesc('id')->get(),
        ]);
    }
}
