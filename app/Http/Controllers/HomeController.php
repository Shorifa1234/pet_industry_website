<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Product;
use App\Models\Company;
use App\Models\Event;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArticles = Article::published()->featured()->with('category')->latest('published_at')->take(3)->get();
        $latestArticles = Article::published()->with('category')->latest('published_at')->take(6)->get();
        $featuredProducts = Product::published()->where('is_featured', true)->with('company')->take(6)->get();
        $featuredCompanies = Company::where('status', 'active')->where('is_featured', true)->take(6)->get();
        $upcomingEvents = Event::upcoming()->take(4)->get();
        $articleCategories = Category::where('type', 'article')->where('is_active', true)->get();

        return view('frontend.home', compact(
            'featuredArticles', 'latestArticles', 'featuredProducts',
            'featuredCompanies', 'upcomingEvents', 'articleCategories'
        ));
    }
}
