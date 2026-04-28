<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\View\View;

class AuthorPageController extends Controller
{
    public function show(int $id): View
    {
        $author = Author::query()
            ->with([
                'articles' => fn ($query) => $query
                    ->with('category')
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->latest('id'),
            ])
            ->findOrFail($id);

        return view('front.authors.show', [
            'author' => $author,
            'articles' => $author->articles,
        ]);
    }
}
