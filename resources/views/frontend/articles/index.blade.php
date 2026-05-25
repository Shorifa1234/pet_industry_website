@extends('layouts.app')

@section('title', 'Industry News - Food & Beverage')

@section('content')

<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        <h1 style="font-size:28px;font-weight:700;margin:0;"><i class="fas fa-newspaper me-2"></i>Industry News</h1>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.5);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:rgba(255,255,255,0.8);">Home</a></li>
                <li class="breadcrumb-item active text-white">News</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">

            {{-- Category Filter --}}
            @if(isset($category))
            <div class="alert" style="background:var(--light-bg);border:1px solid var(--border);border-radius:6px;">
                <i class="fas fa-filter me-2" style="color:var(--secondary)"></i>
                Showing news in: <strong>{{ $category->name }}</strong>
                <a href="{{ route('articles.index') }}" class="ms-2 text-muted" style="font-size:12px;">(Clear filter)</a>
            </div>
            @endif

            {{-- Search Filter --}}
            <div class="mb-4">
                <form action="{{ route('articles.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Search articles..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-search me-1"></i>Search</button>
                </form>
            </div>

            {{-- Articles Grid --}}
            @if($articles->count())
            <div class="row g-3 mb-4">
                @foreach($articles as $article)
                <div class="col-md-6">
                    <div class="article-card">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}">
                        @else
                            <div style="height:200px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-newspaper fa-3x text-white opacity-40"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            @if($article->category)
                                <a href="{{ route('articles.category', $article->category) }}" class="category-badge">{{ $article->category->name }}</a>
                            @endif
                            <h6 class="card-title"><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h6>
                            @if($article->excerpt)
                                <p style="font-size:13px;color:var(--text-muted);line-height:1.5;margin-bottom:8px;">{{ Str::limit($article->excerpt, 100) }}</p>
                            @endif
                            <div class="card-meta d-flex justify-content-between">
                                <span><i class="fas fa-clock me-1"></i>{{ $article->published_at?->diffForHumans() ?? $article->created_at->diffForHumans() }}</span>
                                <span><i class="fas fa-eye me-1"></i>{{ number_format($article->views) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{ $articles->links() }}

            @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No articles found</h5>
                <p class="text-muted">Try a different search term or browse all news.</p>
                <a href="{{ route('articles.index') }}" class="btn btn-primary">Browse All News</a>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <h5><i class="fas fa-tags me-2"></i>Topics</h5>
                <div class="sidebar-list">
                    <a href="{{ route('articles.index') }}" style="{{ !isset($category) ? 'font-weight:700;color:var(--primary)' : '' }}">
                        <i class="fas fa-chevron-right me-2" style="font-size:10px;color:var(--secondary)"></i>All Topics
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('articles.category', $cat) }}" style="{{ isset($category) && $category->id == $cat->id ? 'font-weight:700;color:var(--primary)' : '' }}">
                        <i class="fas fa-chevron-right me-2" style="font-size:10px;color:var(--secondary)"></i>{{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-widget">
                <h5><i class="fas fa-fire me-2"></i>Popular Articles</h5>
                <div class="sidebar-list">
                    @foreach(\App\Models\Article::published()->orderBy('views','desc')->take(5)->get() as $a)
                    <a href="{{ route('articles.show', $a) }}">
                        <div style="font-size:13px;font-weight:500;">{{ Str::limit($a->title, 60) }}</div>
                        <div style="font-size:11px;color:var(--text-muted);"><i class="fas fa-eye me-1"></i>{{ number_format($a->views) }} views</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
