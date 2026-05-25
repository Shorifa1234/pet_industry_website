@extends('layouts.app')
@section('title', 'Products Directory - Food & Beverage')
@section('content')
<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        <h1 style="font-size:28px;font-weight:700;margin:0;"><i class="fas fa-box-open me-2"></i>Products Directory</h1>
        <p style="opacity:0.85;margin:5px 0 0;">Discover food & beverage industry products</p>
    </div>
</div>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sidebar-widget">
                <h5><i class="fas fa-filter me-2"></i>Filter Products</h5>
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;">Category</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filter</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-1">Clear</a>
                </form>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span style="font-size:14px;color:var(--text-muted);">Showing {{ $products->total() }} products</span>
            </div>
            @if($products->count())
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-md-4">
                    <div class="article-card">
                        @if($product->featured_image)
                            <img src="{{ asset('storage/'.$product->featured_image) }}" alt="{{ $product->name }}">
                        @else
                            <div style="height:200px;background:var(--light-bg);display:flex;align-items:center;justify-content:center;"><i class="fas fa-box fa-3x text-muted opacity-50"></i></div>
                        @endif
                        <div class="card-body">
                            @if($product->category)
                                <span class="category-badge">{{ $product->category->name }}</span>
                            @endif
                            <h6 class="card-title"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h6>
                            @if($product->company)
                                <div style="font-size:12px;color:var(--text-muted);">by <a href="{{ route('companies.show', $product->company) }}" style="color:var(--primary);">{{ $product->company->name }}</a></div>
                            @endif
                            @if($product->short_description)
                                <p style="font-size:12px;color:var(--text-muted);margin-top:6px;">{{ Str::limit($product->short_description, 80) }}</p>
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $products->appends(request()->query())->links() }}</div>
            @else
            <div class="text-center py-5"><i class="fas fa-box fa-3x text-muted mb-3"></i><h5 class="text-muted">No products found</h5></div>
            @endif
        </div>
    </div>
</div>
@endsection
