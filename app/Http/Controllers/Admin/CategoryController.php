<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = DB::table('categories')
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        DB::table('categories')->insert([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(int $category): View
    {
        $categoryRow = DB::table('categories')
            ->where('id', $category)
            ->whereNull('deleted_at')
            ->first();

        abort_if(! $categoryRow, 404);

        return view('admin.categories.edit', ['category' => $categoryRow]);
    }

    public function update(UpdateCategoryRequest $request, int $category): RedirectResponse
    {
        $categoryExists = DB::table('categories')
            ->where('id', $category)
            ->whereNull('deleted_at')
            ->exists();

        abort_if(! $categoryExists, 404);

        DB::table('categories')
            ->where('id', $category)
            ->update([
                'name' => $request->validated('name'),
                'slug' => $request->validated('slug'),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(int $category): RedirectResponse
    {
        $categoryExists = DB::table('categories')
            ->where('id', $category)
            ->whereNull('deleted_at')
            ->exists();

        abort_if(! $categoryExists, 404);

        if ($this->hasLinkedArticles($category)) {
            return back()->withErrors([
                'delete' => 'Category cannot be deleted because it has linked articles.',
            ]);
        }

        DB::table('categories')
            ->where('id', $category)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category moved to trash successfully.');
    }

    public function trashed(): View
    {
        $categories = DB::table('categories')
            ->whereNotNull('deleted_at')
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('admin.categories.trashed', compact('categories'));
    }

    public function restore(int $category): RedirectResponse
    {
        $trashedExists = DB::table('categories')
            ->where('id', $category)
            ->whereNotNull('deleted_at')
            ->exists();

        abort_if(! $trashedExists, 404);

        DB::table('categories')
            ->where('id', $category)
            ->update([
                'deleted_at' => null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete(int $category): RedirectResponse
    {
        $trashedExists = DB::table('categories')
            ->where('id', $category)
            ->whereNotNull('deleted_at')
            ->exists();

        abort_if(! $trashedExists, 404);

        if ($this->hasLinkedArticles($category)) {
            return back()->withErrors([
                'delete' => 'Category cannot be permanently deleted because it has linked articles.',
            ]);
        }

        DB::table('categories')
            ->where('id', $category)
            ->delete();

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', 'Category permanently deleted successfully.');
    }

    private function hasLinkedArticles(int $categoryId): bool
    {
        return DB::table('articles')
            ->where('category_id', $categoryId)
            ->exists();
    }
}
