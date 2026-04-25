<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())->latest()->get();
        return view('author.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array',
            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        // رفع الصورة
        $path = $request->file('cover_image')->store('articles', 'public');

        // حفظ المقال كمسودة (draft)
        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'content' => $request->content,
            'cover_image' => $path,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'status' => 'draft', // حسب المطلوب في المهمة
        ]);

        $article->tags()->attach($request->tags);

        return redirect()->route('author.articles.index')->with('success', 'تم حفظ المقال كمسودة بنجاح');
    }
}
