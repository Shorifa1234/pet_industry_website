@extends('layouts.app')
@section('title', $company->name . ' - Company Profile | Food & Industry')
@section('meta_description', $company->meta_description ?? Str::limit(strip_tags($company->description ?? $company->name . ' - food & beverage company profile, products and contact information.'), 160))
@section('meta_keywords', $company->name . ', ' . ($company->industry_type ?? 'food company') . ', food & beverage company, F&B supplier')
@section('canonical', route('companies.show', $company))
@section('og_title', $company->name . ' - Company Profile')
@section('og_description', $company->meta_description ?? Str::limit(strip_tags($company->description ?? ''), 200))
@section('og_image', $company->logo ? asset('storage/'.$company->logo) : asset('images/logo.svg'))

@push('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ addslashes($company->name) }}",
  "url": "{{ route('companies.show', $company) }}"
  @if($company->logo),"logo": "{{ asset('storage/'.$company->logo) }}"@endif
  @if($company->website),"sameAs": ["{{ $company->website }}"]@endif
  @if($company->email),"email": "{{ $company->email }}"@endif
  @if($company->phone),"telephone": "{{ $company->phone }}"@endif
  @if($company->address || $company->city),"address": {
    "@type": "PostalAddress"
    @if($company->address),"streetAddress": "{{ addslashes($company->address) }}"@endif
    @if($company->city),"addressLocality": "{{ addslashes($company->city) }}"@endif
    @if($company->state),"addressRegion": "{{ addslashes($company->state) }}"@endif
    @if($company->country),"addressCountry": "{{ addslashes($company->country) }}"@endif
  }@endif
  @if($company->description),"description": "{{ addslashes(Str::limit(strip_tags($company->description), 300)) }}"@endif
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
    { "@type": "ListItem", "position": 2, "name": "Directory", "item": "{{ route('companies.index') }}" },
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($company->name) }}" }
  ]
}
</script>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div style="background:var(--light-bg);border-bottom:1px solid var(--border);padding:8px 0;font-size:12px;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <a href="{{ route('home') }}" style="color:var(--primary);text-decoration:none;">Home</a>
            <span class="mx-1 text-muted">/</span>
            <a href="{{ route('companies.index') }}" style="color:var(--primary);text-decoration:none;">Directory</a>
            <span class="mx-1 text-muted">/</span>
            <span class="text-muted">{{ $company->name }}</span>
        </nav>
    </div>
</div>
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
