<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->trim()->toString();

        return view('news.index', [
            'featuredArticle' => Article::published()->with('category')->where('featured', true)->latest('published_at')->first(),
            'articles' => Article::published()->with('category')
                ->when($category !== '', fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $category)))
                ->latest('published_at')->paginate(12)->withQueryString(),
            'categories' => ArticleCategory::query()->where('active', true)->orderBy('sort_order')->get(),
            'selectedCategory' => $category,
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->active && $article->published_at?->isPast(), 404);

        $article->load('category');

        return view('news.show', compact('article'));
    }
}
