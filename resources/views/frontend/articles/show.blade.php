@extends('layouts.app')

@section('title', ($article->meta_title ?? $article->title) . ' | Food & Industry')
@section('meta_description', $article->meta_description ?? $article->excerpt ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->tags ? $article->tags . ', food industry news, beverage industry' : 'food industry news, beverage industry, F&B news')
@section('canonical', route('articles.show', $article))
@section('og_type', 'article')
@section('og_title', $article->meta_title ?? $article->title)
@section('og_description', $article->meta_description ?? $article->excerpt ?? Str::limit(strip_tags($article->content), 200))
@section('og_image', $article->featured_image ? asset('storage/'.$article->featured_image) : asset('images/logo.svg'))

@push('seo')
<meta property="article:published_time" content="{{ $article->published_at?->toIso8601String() ?? $article->created_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
<meta property="article:author" content="{{ $article->author_name ?? $article->user?->name ?? 'Editorial Team' }}">
@if($article->category)<meta property="article:section" content="{{ $article->category->name }}">@endif
@if($article->tags)@foreach(explode(',', $article->tags) as $tag)<meta property="article:tag" content="{{ trim($tag) }}">@endforeach@endif
@endpush

@push('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ addslashes($article->title) }}",
  "description": "{{ addslashes($article->excerpt ?? Str::limit(strip_tags($article->content), 160)) }}",
  "image": "{{ $article->featured_image ? asset('storage/'.$article->featured_image) : asset('images/logo.svg') }}",
  "url": "{{ route('articles.show', $article) }}",
  "datePublished": "{{ $article->published_at?->toIso8601String() ?? $article->created_at->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": { "@type": "Person", "name": "{{ addslashes($article->author_name ?? $article->user?->name ?? 'Editorial Team') }}" },
  "publisher": {
    "@type": "Organization",
    "name": "Food & Industry Portal",
    "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.svg') }}" }
  },
  "mainEntityOfPage": { "@type": "WebPage", "@id": "{{ route('articles.show', $article) }}" }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
    { "@type": "ListItem", "position": 2, "name": "News", "item": "{{ route('articles.index') }}" },
    @if($article->category){ "@type": "ListItem", "position": 3, "name": "{{ addslashes($article->category->name) }}", "item": "{{ route('articles.category', $article->category) }}" },
    { "@type": "ListItem", "position": 4, "name": "{{ addslashes($article->title) }}" }
    @else{ "@type": "ListItem", "position": 3, "name": "{{ addslashes($article->title) }}" }@endif
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
            <a href="{{ route('articles.index') }}" style="color:var(--primary);text-decoration:none;">News</a>
            @if($article->category)
            <span class="mx-1 text-muted">/</span>
            <a href="{{ route('articles.category', $article->category) }}" style="color:var(--primary);text-decoration:none;">{{ $article->category->name }}</a>
            @endif
            <span class="mx-1 text-muted">/</span>
            <span class="text-muted">{{ Str::limit($article->title, 50) }}</span>
        </nav>
    </div>
</div>

<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        @if($article->category)
            <a href="{{ route('articles.category', $article->category) }}" class="category-badge" style="background:var(--secondary);">{{ $article->category->name }}</a>
        @endif
        <h1 style="font-size:26px;font-weight:700;margin:10px 0 8px;">{{ $article->title }}</h1>
        <div style="font-size:13px;opacity:0.85;">
            <i class="fas fa-user me-1"></i>{{ $article->author_name ?? $article->user?->name ?? 'Editorial Team' }}
            &nbsp;|&nbsp;
            <i class="fas fa-clock me-1"></i>{{ $article->published_at?->format('F j, Y') ?? $article->created_at->format('F j, Y') }}
            &nbsp;|&nbsp;
            <i class="fas fa-eye me-1"></i>{{ number_format($article->views) }} views
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            @if($article->featured_image)
            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid rounded mb-4" style="width:100%;max-height:450px;object-fit:cover;">
            @endif
            <div style="font-size:16px;line-height:1.8;color:var(--text-dark);">{!! $article->content !!}</div>
            @if($article->tags)
            <div class="mt-4 pt-3 border-top">
                <strong style="font-size:13px;"><i class="fas fa-tags me-2" style="color:var(--secondary)"></i>Tags:</strong>
                @foreach(explode(',', $article->tags) as $tag)
                    <span class="tag-badge">{{ trim($tag) }}</span>
                @endforeach
            </div>
            @endif
            <div class="mt-4 pt-3 border-top">
                <strong style="font-size:13px;">Share:</strong>
                <a href="#" class="btn btn-sm ms-2" style="background:#0077b5;color:#fff;border:none;"><i class="fab fa-linkedin me-1"></i>LinkedIn</a>
                <a href="#" class="btn btn-sm ms-1" style="background:#1da1f2;color:#fff;border:none;"><i class="fab fa-twitter me-1"></i>Twitter</a>
                <a href="#" class="btn btn-sm ms-1" style="background:#4267b2;color:#fff;border:none;"><i class="fab fa-facebook me-1"></i>Facebook</a>
            </div>
            @if($relatedArticles->count())
            <div class="mt-5">
                <div class="section-header"><h2>Related Articles</h2></div>
                <div class="row g-3">
                    @foreach($relatedArticles as $related)
                    <div class="col-md-4">
                        <div class="article-card">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/'.$related->featured_image) }}" alt="{{ $related->title }}">
                            @else
                                <div style="height:140px;background:var(--light-bg);display:flex;align-items:center;justify-content:center;"><i class="fas fa-newspaper fa-2x text-muted"></i></div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title" style="font-size:13px;"><a href="{{ route('articles.show', $related) }}">{{ $related->title }}</a></h6>
                                <div class="card-meta"><i class="fas fa-clock me-1"></i>{{ $related->published_at?->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <h5><i class="fas fa-tags me-2"></i>Topics</h5>
                <div class="sidebar-list">
                    @foreach(\App\Models\Category::where('type','article')->where('is_active',true)->get() as $cat)
                    <a href="{{ route('articles.category', $cat) }}">
                        <i class="fas fa-chevron-right me-2" style="font-size:10px;color:var(--secondary)"></i>{{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="sidebar-widget">
                <h5><i class="fas fa-fire me-2"></i>Popular Articles</h5>
                <div class="sidebar-list">
                    @foreach(\App\Models\Article::published()->orderBy('views','desc')->where('id','!=',$article->id)->take(5)->get() as $a)
                    <a href="{{ route('articles.show', $a) }}">
                        <div style="font-size:13px;font-weight:500;">{{ Str::limit($a->title, 60) }}</div>
                        <div style="font-size:11px;color:var(--text-muted);"><i class="fas fa-eye me-1"></i>{{ number_format($a->views) }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
