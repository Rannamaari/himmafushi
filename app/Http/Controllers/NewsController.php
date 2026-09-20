<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'featuredArticle' => Article::published()->where('featured', true)->latest('published_at')->first(),
            'articles' => Article::published()->latest('published_at')->paginate(12),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->active && $article->published_at?->isPast(), 404);

        return view('news.show', compact('article'));
    }
}
