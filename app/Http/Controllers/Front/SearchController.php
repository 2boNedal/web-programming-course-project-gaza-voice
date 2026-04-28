<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagSuggestRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $selectedTagNames = collect($request->query('tags', []))
            ->filter(fn ($tag) => filled($tag))
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->unique()
            ->values();

        $selectedTags = Tag::query()
            ->whereIn('name', $selectedTagNames)
            ->orderBy('name')
            ->get(['id', 'name']);

        $articles = Article::query()
            ->with(['category', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when(
                $selectedTags->isNotEmpty(),
                fn ($query) => $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('tags.id', $selectedTags->pluck('id'))),
                fn ($query) => $query->whereRaw('1 = 0')
            )
            ->orderBy('published_at')
            ->orderBy('id')
            ->paginate(9)
            ->withQueryString();

        return view('front.search-results', [
            'articles' => $articles,
            'availableTags' => Tag::query()->orderBy('name')->get(['id', 'name']),
            'selectedTags' => $selectedTags,
        ]);
    }

    public function suggest(TagSuggestRequest $request): JsonResponse
    {
        $query = trim((string) $request->validated('q', ''));

        if ($query === '') {
            return response()->json([], 200);
        }

        $tags = Tag::query()
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($tags, 200);
    }

    public function redirectLegacy(Request $request): RedirectResponse
    {
        return redirect()->route('search.index', $request->query());
    }
}
