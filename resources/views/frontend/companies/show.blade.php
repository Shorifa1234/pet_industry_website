@extends('layouts.app')
@section('title', $company->name . ' - Company Profile')
@section('content')
<div style="background:var(--primary);color:#fff;padding:30px 0;">
    <div class="container">
        <div class="d-flex align-items-center">
            @if($company->logo)
                <div style="width:80px;height:80px;background:#fff;border-radius:8px;margin-right:20px;display:flex;align-items:center;justify-content:center;padding:8px;">
                    <img src="{{ asset('storage/'.$company->logo) }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                </div>
            @endif
            <div>
                <h1 style="font-size:26px;font-weight:700;margin:0;">{{ $company->name }}</h1>
                @if($company->city || $company->country)<div style="opacity:0.85;margin-top:5px;"><i class="fas fa-map-marker-alt me-1"></i>{{ $company->city }}{{ $company->country ? ', '.$company->country : '' }}</div>@endif
                @if($company->industry_type)<span style="background:var(--secondary);font-size:12px;padding:3px 12px;border-radius:3px;margin-top:6px;display:inline-block;">{{ $company->industry_type }}</span>@endif
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            @if($company->description)
            <div class="mb-4"><h5 style="color:var(--primary);border-bottom:2px solid var(--secondary);padding-bottom:8px;">About {{ $company->name }}</h5><div style="font-size:15px;line-height:1.8;">{!! nl2br(e($company->description)) !!}</div></div>
            @endif
            @if($products->count())
            <div class="section-header"><h2>Products from {{ $company->name }}</h2></div>
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-md-4">
                    <div class="article-card">
                        @if($product->featured_image)<img src="{{ asset('storage/'.$product->featured_image) }}" alt="{{ $product->name }}">
                        @else<div style="height:150px;background:var(--light-bg);display:flex;align-items:center;justify-content:center;"><i class="fas fa-box fa-2x text-muted"></i></div>@endif
                        <div class="card-body"><h6 class="card-title" style="font-size:13px;"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h6></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <h5><i class="fas fa-address-card me-2"></i>Contact Information</h5>
                @if($company->website)<div class="mb-2"><i class="fas fa-globe me-2" style="color:var(--secondary)"></i><a href="{{ $company->website }}" target="_blank" style="color:var(--primary);font-size:13px;">{{ $company->website }}</a></div>@endif
                @if($company->email)<div class="mb-2"><i class="fas fa-envelope me-2" style="color:var(--secondary)"></i><span style="font-size:13px;">{{ $company->email }}</span></div>@endif
                @if($company->phone)<div class="mb-2"><i class="fas fa-phone me-2" style="color:var(--secondary)"></i><span style="font-size:13px;">{{ $company->phone }}</span></div>@endif
                @if($company->address || $company->city)
                <div class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color:var(--secondary)"></i><span style="font-size:13px;">{{ implode(', ', array_filter([$company->address, $company->city, $company->state, $company->country])) }}</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
