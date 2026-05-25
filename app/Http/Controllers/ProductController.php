<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::published()->with(['category', 'company']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::where('type', 'product')->where('is_active', true)->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->status !== 'published') {
            abort(404);
        }
        $relatedProducts = Product::published()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
