@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-2 col-6">
        <div class="stat-card">
            <div class="icon" style="background:#1a5276;"><i class="fas fa-newspaper"></i></div>
            <div><div class="value">{{ $stats['articles'] }}</div><div class="label">Total Articles</div></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card" style="border-left-color:#27ae60;">
            <div class="icon" style="background:#27ae60;"><i class="fas fa-check-circle"></i></div>
            <div><div class="value">{{ $stats['published_articles'] }}</div><div class="label">Published</div></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card" style="border-left-color:#e67e22;">
            <div class="icon" style="background:#e67e22;"><i class="fas fa-box-open"></i></div>
            <div><div class="value">{{ $stats['products'] }}</div><div class="label">Products</div></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card" style="border-left-color:#8e44ad;">
            <div class="icon" style="background:#8e44ad;"><i class="fas fa-building"></i></div>
            <div><div class="value">{{ $stats['companies'] }}</div><div class="label">Companies</div></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card" style="border-left-color:#2980b9;">
            <div class="icon" style="background:#2980b9;"><i class="fas fa-calendar-alt"></i></div>
            <div><div class="value">{{ $stats['events'] }}</div><div class="label">Events</div></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card" style="border-left-color:#16a085;">
            <div class="icon" style="background:#16a085;"><i class="fas fa-users"></i></div>
            <div><div class="value">{{ $stats['users'] }}</div><div class="label">Users</div></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="data-table">
            <div class="table-header">
                <h6><i class="fas fa-newspaper me-2"></i>Recent Articles</h6>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>New Article</a>
            </div>
            <table class="table table-hover">
                <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th></th></tr></thead>
                <tbody>
                    @forelse($recentArticles as $article)
                    <tr>
                        <td><strong>{{ Str::limit($article->title, 50) }}</strong></td>
                        <td>{{ $article->category?->name ?? '-' }}</td>
                        <td><span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span></td>
                        <td>{{ $article->created_at->format('M j, Y') }}</td>
                        <td><a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No articles yet</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="padding:12px 20px;border-top:1px solid #dee2e6;">
                <a href="{{ route('admin.articles.index') }}" style="font-size:13px;color:var(--primary);">View all articles &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="data-table">
            <div class="table-header">
                <h6><i class="fas fa-users me-2"></i>Recent Users</h6>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Add</a>
            </div>
            @foreach($recentUsers as $user)
            <div style="padding:12px 16px;border-bottom:1px solid #dee2e6;display:flex;align-items:center;">
                <div style="width:36px;height:36px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;margin-right:10px;flex-shrink:0;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $user->name }}</div>
                    <div style="font-size:11px;color:#7f8c8d;">{{ $user->email }}</div>
                </div>
                <span class="ms-auto badge bg-secondary" style="font-size:10px;">{{ ucfirst($user->role) }}</span>
            </div>
            @endforeach
        </div>

        <div class="form-card mt-3">
            <h6 style="color:var(--primary);margin-bottom:15px;font-weight:700;"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus me-2"></i>New Article</a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-plus me-2"></i>Add Product</a>
                <a href="{{ route('admin.companies.create') }}" class="btn btn-outline-success btn-sm"><i class="fas fa-plus me-2"></i>Add Company</a>
                <a href="{{ route('admin.events.create') }}" class="btn btn-outline-info btn-sm"><i class="fas fa-plus me-2"></i>Add Event</a>
            </div>
        </div>
    </div>
</div>
@endsection
