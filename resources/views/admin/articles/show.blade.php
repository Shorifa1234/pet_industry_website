@extends('layouts.admin')
@section('title', 'View Article')
@section('page-title', 'Article Details')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 style="margin:0;">{{ $article->title }}</h5>
                <span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span>
            </div>
            @if($article->featured_image)
                <img src="{{ asset('storage/'.$article->featured_image) }}" class="img-fluid rounded mb-3" style="max-height:300px;width:100%;object-fit:cover;">
            @endif
            @if($article->excerpt)
                <p style="color:#555;font-style:italic;border-left:3px solid var(--primary);padding-left:12px;">{{ $article->excerpt }}</p>
            @endif
            <div style="line-height:1.8;">{{ $article->content }}</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-card mb-3">
            <h6 style="color:var(--primary);margin-bottom:15px;">Article Info</h6>
            <table class="table table-sm table-borderless" style="font-size:13px;">
                <tr><td class="text-muted">Category</td><td>{{ $article->category?->name ?? '-' }}</td></tr>
                <tr><td class="text-muted">Author</td><td>{{ $article->author_name ?? $article->user?->name ?? '-' }}</td></tr>
                <tr><td class="text-muted">Views</td><td>{{ number_format($article->views) }}</td></tr>
                <tr><td class="text-muted">Published</td><td>{{ $article->published_at?->format('M j, Y') ?? '-' }}</td></tr>
                <tr><td class="text-muted">Created</td><td>{{ $article->created_at->format('M j, Y') }}</td></tr>
                <tr><td class="text-muted">Featured</td><td>{{ $article->is_featured ? 'Yes' : 'No' }}</td></tr>
                @if($article->tags)<tr><td class="text-muted">Tags</td><td>{{ $article->tags }}</td></tr>@endif
            </table>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Article</a>
            @if($article->status == 'published')
                <a href="{{ route('articles.show', $article) }}" target="_blank" class="btn btn-outline-success"><i class="fas fa-external-link-alt me-2"></i>View on Site</a>
            @endif
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
