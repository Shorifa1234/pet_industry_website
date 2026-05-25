@extends('layouts.app')

@section('title', 'Food & Beverage Industry Portal - Home')

@section('content')

{{-- Hero Section --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1><i class="fas fa-industry me-3"></i>Food & Beverage Industry</h1>
                <p class="lead mb-4">Your trusted source for industry news, product innovations, company directory and upcoming events in the food & beverage sector.</p>
                <a href="{{ route('articles.index') }}" class="btn btn-lg me-2" style="background:var(--secondary);color:#fff;border:none;">Read Latest News</a>
                <a href="{{ route('companies.index') }}" class="btn btn-lg btn-outline-light">Browse Directory</a>
            </div>
            <div class="col-md-5 d-none d-md-block text-center">
                <div style="font-size:120px;opacity:0.3;"><i class="fas fa-industry"></i></div>
            </div>
        </div>
    </div>
</section>

{{-- Breaking News Ticker --}}
@if($latestArticles->count())
<div style="background:var(--secondary);color:#fff;padding:8px 0;font-size:13px;">
    <div class="container d-flex align-items-center">
        <span class="fw-bold me-3 text-nowrap"><i class="fas fa-bolt me-1"></i>LATEST:</span>
        <div style="overflow:hidden;">
            @foreach($latestArticles->take(3) as $a)
                <a href="{{ route('articles.show', $a) }}" style="color:#fff;text-decoration:none;" class="me-4">{{ $a->title }}</a>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="container py-4">
    <div class="row">

        {{-- Main Content --}}
        <div class="col-lg-8">

            {{-- Featured Articles --}}
            @if($featuredArticles->count())
            <div class="section-header d-flex justify-content-between align-items-center">
                <div><h2><i class="fas fa-star me-2" style="color:var(--secondary)"></i>Featured News</h2></div>
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="row g-3 mb-4">
                @foreach($featuredArticles as $article)
                <div class="col-md-4">
                    <div class="article-card">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}">
                        @else
                            <div style="height:200px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-newspaper fa-3x text-white opacity-50"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            @if($article->category)
                                <a href="{{ route('articles.category', $article->category) }}" class="category-badge">{{ $article->category->name }}</a>
                            @endif
                            <h6 class="card-title"><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h6>
                            <div class="card-meta"><i class="fas fa-clock me-1"></i>{{ $article->published_at?->diffForHumans() ?? $article->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Latest News --}}
            <div class="section-header d-flex justify-content-between align-items-center">
                <div><h2><i class="fas fa-newspaper me-2" style="color:var(--secondary)"></i>Latest News</h2></div>
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>

            @forelse($latestArticles as $article)
            <div class="d-flex mb-3 pb-3 border-bottom align-items-start">
                @if($article->featured_image)
                    <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" style="width:100px;height:70px;object-fit:cover;border-radius:4px;flex-shrink:0;margin-right:15px;">
                @else
                    <div style="width:100px;height:70px;background:var(--light-bg);border-radius:4px;flex-shrink:0;margin-right:15px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-newspaper text-muted"></i>
                    </div>
                @endif
                <div>
                    @if($article->category)
                        <a href="{{ route('articles.category', $article->category) }}" class="category-badge" style="font-size:10px;">{{ $article->category->name }}</a>
                    @endif
                    <h6 class="mb-1"><a href="{{ route('articles.show', $article) }}" style="color:var(--text-dark);text-decoration:none;font-weight:600;">{{ $article->title }}</a></h6>
                    <div style="font-size:12px;color:var(--text-muted);">
                        <i class="fas fa-clock me-1"></i>{{ $article->published_at?->diffForHumans() ?? $article->created_at->diffForHumans() }}
                        @if($article->views) &nbsp;|&nbsp; <i class="fas fa-eye me-1"></i>{{ number_format($article->views) }} views @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <i class="fas fa-newspaper fa-2x mb-2"></i>
                <p>No articles yet. <a href="{{ route('admin.articles.create') }}">Add the first article</a></p>
            </div>
            @endforelse

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Categories --}}
            <div class="sidebar-widget">
                <h5><i class="fas fa-tags me-2"></i>News Topics</h5>
                <div class="sidebar-list">
                    @forelse($articleCategories as $cat)
                        <a href="{{ route('articles.category', $cat) }}">
                            <i class="fas fa-chevron-right me-2" style="font-size:10px;color:var(--secondary)"></i>
                            {{ $cat->name }}
                            <span class="float-end badge" style="background:var(--light-bg);color:var(--text-dark);">{{ $cat->articles_count ?? '' }}</span>
                        </a>
                    @empty
                        <p class="text-muted mb-0" style="font-size:13px;">No categories yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Featured Products --}}
            @if($featuredProducts->count())
            <div class="sidebar-widget">
                <h5><i class="fas fa-box-open me-2"></i>Featured Products</h5>
                @foreach($featuredProducts->take(4) as $product)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/'.$product->featured_image) }}" style="width:55px;height:55px;object-fit:cover;border-radius:4px;margin-right:12px;">
                    @else
                        <div style="width:55px;height:55px;background:var(--border);border-radius:4px;margin-right:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-box text-muted"></i></div>
                    @endif
                    <div>
                        <a href="{{ route('products.show', $product) }}" style="font-size:13px;font-weight:600;color:var(--text-dark);text-decoration:none;">{{ $product->name }}</a>
                        @if($product->company)<div style="font-size:11px;color:var(--text-muted);">{{ $product->company->name }}</div>@endif
                    </div>
                </div>
                @endforeach
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary w-100">View All Products</a>
            </div>
            @endif

            {{-- Upcoming Events --}}
            @if($upcomingEvents->count())
            <div class="sidebar-widget">
                <h5><i class="fas fa-calendar-alt me-2"></i>Upcoming Events</h5>
                @foreach($upcomingEvents as $event)
                <div class="d-flex mb-3 pb-3 border-bottom">
                    <div style="background:var(--primary);color:#fff;text-align:center;padding:8px 12px;border-radius:4px;margin-right:12px;min-width:50px;flex-shrink:0;">
                        <div style="font-size:18px;font-weight:700;">{{ $event->start_date->format('d') }}</div>
                        <div style="font-size:10px;text-transform:uppercase;">{{ $event->start_date->format('M') }}</div>
                    </div>
                    <div>
                        <a href="{{ route('events.show', $event) }}" style="font-size:13px;font-weight:600;color:var(--text-dark);text-decoration:none;">{{ $event->title }}</a>
                        @if($event->city)<div style="font-size:11px;color:var(--text-muted);"><i class="fas fa-map-marker-alt me-1"></i>{{ $event->city }}{{ $event->country ? ', '.$event->country : '' }}</div>@endif
                    </div>
                </div>
                @endforeach
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary w-100">View All Events</a>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- Featured Companies Section --}}
@if($featuredCompanies->count())
<div style="background:var(--light-bg);padding:40px 0;border-top:1px solid var(--border);">
    <div class="container">
        <div class="section-header mb-4">
            <h2><i class="fas fa-building me-2" style="color:var(--secondary)"></i>Industry Leaders</h2>
        </div>
        <div class="row g-3">
            @foreach($featuredCompanies as $company)
            <div class="col-md-2 col-4">
                <a href="{{ route('companies.show', $company) }}" style="text-decoration:none;">
                    <div style="background:#fff;border:1px solid var(--border);border-radius:6px;padding:15px;text-align:center;transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
                        @if($company->logo)
                            <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}" style="max-width:80px;max-height:50px;object-fit:contain;">
                        @else
                            <div style="font-size:30px;color:var(--primary);"><i class="fas fa-building"></i></div>
                        @endif
                        <div style="font-size:11px;font-weight:600;color:var(--text-dark);margin-top:8px;">{{ Str::limit($company->name, 20) }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('companies.index') }}" class="btn btn-primary">Browse Full Directory <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</div>
@endif

@endsection
