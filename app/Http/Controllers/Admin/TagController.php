<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = DB::table('tags')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        DB::table('tags')->insert([
            'name' => $request->validated('name'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function edit(int $tag): View
    {
        $tagRow = DB::table('tags')->where('id', $tag)->first();

        abort_if(! $tagRow, 404);

        return view('admin.tags.edit', ['tag' => $tagRow]);
    }

    public function update(UpdateTagRequest $request, int $tag): RedirectResponse
    {
        $tagExists = DB::table('tags')->where('id', $tag)->exists();

        abort_if(! $tagExists, 404);

        DB::table('tags')
            ->where('id', $tag)
            ->update([
                'name' => $request->validated('name'),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(int $tag): RedirectResponse
    {
        $tagExists = DB::table('tags')->where('id', $tag)->exists();

        abort_if(! $tagExists, 404);

        if ($this->isUsedByArticles($tag)) {
            return back()->withErrors([
                'delete' => 'Tag cannot be deleted because it is used by one or more articles.',
            ]);
        }

        DB::table('tags')->where('id', $tag)->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }

    private function isUsedByArticles(int $tagId): bool
    {
        return DB::table('article_tag')
            ->where('tag_id', $tagId)
            ->exists();
    }
}
