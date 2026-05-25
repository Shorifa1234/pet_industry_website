<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Product;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'products' => Product::count(),
            'companies' => Company::count(),
            'events' => Event::count(),
            'users' => User::count(),
            'published_articles' => Article::where('status', 'published')->count(),
        ];

        $recentArticles = Article::with('category')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentUsers'));
    }
}
