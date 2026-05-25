@extends('layouts.app')
@section('title', $product->meta_title ?? $product->name)
@section('content')
<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        @if($product->category)<span class="category-badge" style="background:var(--secondary);">{{ $product->category->name }}</span>@endif
        <h1 style="font-size:26px;font-weight:700;margin:10px 0 5px;">{{ $product->name }}</h1>
        @if($product->company)<div style="font-size:14px;opacity:0.85;">by {{ $product->company->name }}</div>@endif
    </div>
</div>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            @if($product->featured_image)
            <img src="{{ asset('storage/'.$product->featured_image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-4" style="width:100%;max-height:400px;object-fit:cover;">
            @endif
            <div style="font-size:15px;line-height:1.8;">{!! $product->description ?? $product->short_description !!}</div>
            @if($product->website_url)
            <div class="mt-4">
                <a href="{{ $product->website_url }}" target="_blank" class="btn btn-primary"><i class="fas fa-external-link-alt me-2"></i>Visit Product Website</a>
            </div>
            @endif
        </div>
        <div class="col-lg-4">
            @if($product->company)
            <div class="sidebar-widget">
                <h5><i class="fas fa-building me-2"></i>Company</h5>
                <div class="text-center mb-3">
                    @if($product->company->logo)
                        <img src="{{ asset('storage/'.$product->company->logo) }}" style="max-width:100px;max-height:60px;object-fit:contain;">
                    @endif
                    <div style="font-weight:600;font-size:14px;margin-top:5px;">{{ $product->company->name }}</div>
                </div>
                <a href="{{ route('companies.show', $product->company) }}" class="btn btn-outline-primary btn-sm w-100">View Company Profile</a>
            </div>
            @endif
            @if($product->brand || $product->sku)
            <div class="sidebar-widget">
                <h5><i class="fas fa-info-circle me-2"></i>Product Details</h5>
                @if($product->brand)<div class="mb-2"><strong style="font-size:12px;">Brand:</strong> <span style="font-size:13px;">{{ $product->brand }}</span></div>@endif
                @if($product->sku)<div class="mb-2"><strong style="font-size:12px;">SKU:</strong> <span style="font-size:13px;">{{ $product->sku }}</span></div>@endif
            </div>
            @endif
        </div>
    </div>
    @if($relatedProducts->count())
    <div class="mt-5">
        <div class="section-header"><h2>Related Products</h2></div>
        <div class="row g-3">
            @foreach($relatedProducts as $p)
            <div class="col-md-3">
                <div class="article-card">
                    @if($p->featured_image)<img src="{{ asset('storage/'.$p->featured_image) }}" alt="{{ $p->name }}">
                    @else<div style="height:150px;background:var(--light-bg);display:flex;align-items:center;justify-content:center;"><i class="fas fa-box fa-2x text-muted"></i></div>@endif
                    <div class="card-body"><h6 class="card-title" style="font-size:13px;"><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></h6></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
