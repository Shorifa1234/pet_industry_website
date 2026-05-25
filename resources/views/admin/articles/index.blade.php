@extends('layouts.admin')
@section('title', 'Articles')
@section('page-title', 'Articles / News Management')
@section('content')
<div class="data-table">
    <div class="table-header">
        <h6><i class="fas fa-newspaper me-2"></i>All Articles ({{ $articles->total() }})</h6>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>New Article</a>
    </div>
    <table class="table table-hover">
        <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Status</th><th>Views</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td><strong>{{ Str::limit($article->title, 55) }}</strong></td>
                <td>{{ $article->category?->name ?? '-' }}</td>
                <td>{{ $article->author_name ?? $article->user?->name ?? '-' }}</td>
                <td><span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span></td>
                <td>{{ number_format($article->views) }}</td>
                <td>{{ $article->created_at->format('M j, Y') }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    @if($article->status == 'published')
                        <a href="{{ route('articles.show', $article) }}" target="_blank" class="btn btn-xs btn-outline-success" style="font-size:11px;padding:2px 8px;">View</a>
                    @endif
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="d-inline" onsubmit="return confirm('Delete this article?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No articles yet. <a href="{{ route('admin.articles.create') }}">Create the first one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $articles->links() }}</div>
</div>
@endsection
