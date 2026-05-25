<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('category')->latest('published_at');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->paginate(12);
        $categories = Category::where('type', 'article')->where('is_active', true)->get();

        return view('frontend.articles.index', compact('articles', 'categories'));
    }

    public function byCategory(Category $category)
    {
        $articles = Article::published()->where('category_id', $category->id)->with('category')->latest('published_at')->paginate(12);
        $categories = Category::where('type', 'article')->where('is_active', true)->get();

        return view('frontend.articles.index', compact('articles', 'categories', 'category'));
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published') {
            abort(404);
        }
        $article->increment('views');
        $relatedArticles = Article::published()->where('category_id', $article->category_id)->where('id', '!=', $article->id)->take(3)->get();

        return view('frontend.articles.show', compact('article', 'relatedArticles'));
    }
}
