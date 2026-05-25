@extends('layouts.app')

@section('title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? $article->excerpt)

@section('content')

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
