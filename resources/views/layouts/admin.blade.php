<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Food & Industry Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a5276; --primary-dark:#0e3460; --secondary:#e67e22; --sidebar-width:250px; }
        * { font-family:'Inter',sans-serif; }
        body { background:#f0f2f5; }
        .sidebar { position:fixed; left:0; top:0; width:var(--sidebar-width); height:100vh; background:var(--primary-dark); overflow-y:auto; z-index:1000; }
        .sidebar .brand { padding:20px; background:rgba(0,0,0,0.2); text-decoration:none; display:block; }
        .sidebar .brand-text { color:#fff; font-size:18px; font-weight:700; }
        .sidebar .brand-sub { color:rgba(255,255,255,0.5); font-size:11px; }
        .sidebar .nav-section { padding:15px 20px 5px; font-size:10px; font-weight:700; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:1px; }
        .sidebar .nav-link { color:rgba(255,255,255,0.75); padding:10px 20px; display:flex; align-items:center; text-decoration:none; font-size:13px; transition:all 0.2s; border-left:3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color:#fff; background:rgba(255,255,255,0.1); border-left-color:var(--secondary); }
        .sidebar .nav-link i { width:22px; font-size:14px; }
        .main-content { margin-left:var(--sidebar-width); min-height:100vh; }
        .topbar { background:#fff; padding:12px 25px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,0.08); position:sticky; top:0; z-index:999; }
        .topbar .page-title { font-size:18px; font-weight:700; color:var(--primary); margin:0; }
        .content-area { padding:25px; }
        .stat-card { background:#fff; border-radius:8px; padding:20px; display:flex; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,0.06); border-left:4px solid var(--primary); }
        .stat-card .icon { width:50px; height:50px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff; margin-right:15px; flex-shrink:0; }
        .stat-card .value { font-size:28px; font-weight:700; color:var(--primary); line-height:1; }
        .stat-card .label { font-size:12px; color:#7f8c8d; margin-top:3px; }
        .data-table { background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.06); }
        .data-table .table { margin:0; }
        .data-table .table th { background:#f8f9fa; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#7f8c8d; border-bottom:1px solid #dee2e6; padding:12px 16px; }
        .data-table .table td { padding:12px 16px; font-size:13px; vertical-align:middle; }
        .data-table .table-header { padding:16px 20px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #dee2e6; }
        .data-table .table-header h6 { margin:0; font-weight:700; color:var(--primary); }
        .form-card { background:#fff; border-radius:8px; padding:25px; box-shadow:0 1px 4px rgba(0,0,0,0.06); }
        .form-label { font-size:13px; font-weight:600; color:#495057; }
        .badge-status-published { background:#d4edda; color:#155724; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-status-draft { background:#fff3cd; color:#856404; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-status-archived { background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        @media (max-width:768px) { .sidebar { transform:translateX(-100%); } .main-content { margin-left:0; } }
    </style>
    @stack('styles')
</head>
<body>
<div class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <img src="{{ asset('images/logo.svg') }}" alt="Food &amp; Industry" style="height:44px;width:auto;display:block;">
        <div class="brand-sub" style="margin-top:4px;">Admin Panel</div>
    </a>
    <div class="nav-section">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
    <div class="nav-section">Content</div>
    <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"><i class="fas fa-newspaper"></i>Articles / News</a>
    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-tags"></i>Categories</a>
    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fas fa-box-open"></i>Products</a>
    <a href="{{ route('admin.companies.index') }}" class="nav-link {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}"><i class="fas fa-building"></i>Companies</a>
    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Events</a>
    <div class="nav-section">Users</div>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i>Users</a>
    <div class="nav-section">Website</div>
    <a href="{{ route('home') }}" class="nav-link" target="_blank"><i class="fas fa-external-link-alt"></i>View Website</a>
    <div style="padding:20px;margin-top:20px;border-top:1px solid rgba(255,255,255,0.1);">
        <div style="color:rgba(255,255,255,0.7);font-size:12px;margin-bottom:8px;"><i class="fas fa-user me-2"></i>{{ auth()->user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light w-100" style="font-size:12px;"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        <div style="font-size:13px;color:#7f8c8d;">
            <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
            <span class="badge bg-primary ms-1" style="font-size:10px;">{{ ucfirst(auth()->user()->role) }}</span>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
