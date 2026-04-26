<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // 1. Same category
        $related = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->limit(4)
            ->get()
            ->map(function($item) {
                $item->related_by = 'category';
                return $item;
            });

        // 2. If insufficient, fallback to tags
        if ($related->count() < 4) {
            $tagIds = $article->tags->pluck('id');
            $remainingCount = 4 - $related->count();
            
            $tagRelated = Article::whereHas('tags', function($query) use ($tagIds) {
                    $query->whereIn('tags.id', $tagIds);
                })
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->where('status', 'published')
                ->limit($remainingCount)
                ->get()
                ->map(function($item) {
                    $item->related_by = 'tag';
                    return $item;
                });
                
            $related = $related->concat($tagRelated);
        }

        return view('front.articles.show', compact('article', 'related'));
    }
}
