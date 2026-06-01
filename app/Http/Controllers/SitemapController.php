<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Company;
use App\Models\Event;

class SitemapController extends Controller
{
    public function index()
    {
        $articles  = Article::published()->latest('published_at')->get(['slug', 'updated_at']);
        $products  = Product::published()->latest()->get(['slug', 'updated_at']);
        $companies = Company::where('status', 'active')->latest()->get(['slug', 'updated_at']);
        $events    = Event::where('status', '!=', 'cancelled')->latest('start_date')->get(['slug', 'updated_at']);

        return response()->view('sitemap', compact('articles', 'products', 'companies', 'events'))
            ->header('Content-Type', 'application/xml');
    }
}
