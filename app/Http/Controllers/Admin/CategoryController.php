<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->articles()->withTrashed()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category cannot be deleted while articles are associated with it.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category moved to trash successfully.');
    }

    public function trashed(): View
    {
        $categories = Category::onlyTrashed()->orderBy('name')->get();

        return view('admin.categories.trashed', compact('categories'));
    }

    public function restore(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if ($category->articles()->withTrashed()->exists()) {
            return redirect()
                ->route('admin.categories.trashed')
                ->with('error', 'Category cannot be permanently deleted while articles are associated with it.');
        }

        $category->forceDelete();

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', 'Category permanently deleted successfully.');
    }
}

