<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TagSearchController extends Controller
{
    public function search(Request $request): View
    {
        $selectedTagNames = $this->extractSelectedTagNames($request->query('tags'));

        $selectedTags = collect();

        if (! empty($selectedTagNames)) {
            $selectedTags = DB::table('tags')
                ->whereIn('name', $selectedTagNames)
                ->select('id', 'name')
                ->get();
        }

        $selectedTagIds = $selectedTags->pluck('id')->all();

        $articlesQuery = DB::table('articles')
            ->join('article_tag', 'articles.id', '=', 'article_tag.article_id')
            ->whereNull('articles.deleted_at')
            ->where('articles.status', 'published')
            ->whereNotNull('articles.published_at')
            ->select('articles.id', 'articles.title', 'articles.body', 'articles.cover_image', 'articles.published_at')
            ->distinct()
            ->orderBy('articles.published_at');

        if (empty($selectedTagIds)) {
            $articlesQuery->whereRaw('1 = 0');
        } else {
            $articlesQuery->whereIn('article_tag.tag_id', $selectedTagIds);
        }

        $articles = $articlesQuery->paginate(9)->appends([
            'tags' => implode('|', $selectedTags->pluck('name')->all()),
        ]);

        $articleTags = $this->loadArticleTags($articles->getCollection()->pluck('id'));

        return view('front.search-results', [
            'articles' => $articles,
            'articleTags' => $articleTags,
            'selectedTags' => $selectedTags,
        ]);
    }

    public function suggest(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        if ($query === '') {
            return response()->json([]);
        }

        $tags = DB::table('tags')
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($tags);
    }

    private function extractSelectedTagNames(mixed $rawTags): array
    {
        if (is_array($rawTags)) {
            $values = $rawTags;
        } else {
            $normalized = str_replace(',', '|', (string) $rawTags);
            $values = explode('|', $normalized);
        }

        $cleaned = [];

        foreach ($values as $value) {
            $name = trim((string) $value);

            if ($name !== '') {
                $cleaned[] = $name;
            }
        }

        return array_values(array_unique($cleaned));
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
