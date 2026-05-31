<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'company')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('type', 'product')->where('is_active', true)->get();
        $companies = Company::where('status', 'active')->get();
        return view('admin.products.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('type', 'product')->where('is_active', true)->get();
        $companies = Company::where('status', 'active')->get();
        return view('admin.products.edit', compact('product', 'categories', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
