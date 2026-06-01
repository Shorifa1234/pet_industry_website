<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Food & Beverage Industry Portal - News, Products, Companies, Events')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a5276; --primary-dark: #0e3460;
            --secondary: #e67e22; --accent: #27ae60;
            --light-bg: #f4f6f9; --text-dark: #2c3e50;
            --text-muted: #7f8c8d; --border: #e0e6ed;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #fff; color: var(--text-dark); }
        .top-bar { background: var(--primary-dark); color: #fff; font-size: 12px; padding: 6px 0; }
        .top-bar a { color: rgba(255,255,255,0.8); text-decoration: none; }
        .top-bar a:hover { color: #fff; }
        .main-header { background: var(--primary); padding: 15px 0; }
        .main-header .brand { color: #fff; font-size: 26px; font-weight: 700; text-decoration: none; }
        .main-header .brand span { color: var(--secondary); }
        .main-header .search-form input { border-radius: 25px 0 0 25px; border: none; padding: 8px 20px; }
        .main-header .search-form button { border-radius: 0 25px 25px 0; background: var(--secondary); border: none; color: #fff; padding: 8px 18px; }
        .main-nav { background: var(--primary-dark); }
        .main-nav .navbar-nav .nav-link { color: rgba(255,255,255,0.85) !important; font-size: 14px; font-weight: 500; padding: 12px 16px !important; }
        .main-nav .navbar-nav .nav-link:hover, .main-nav .navbar-nav .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.1); }
        .main-nav .dropdown-menu { border-radius: 0; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .article-card { border: 1px solid var(--border); border-radius: 6px; overflow: hidden; transition: box-shadow 0.2s; height: 100%; }
        .article-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .article-card img { width: 100%; height: 200px; object-fit: cover; }
        .article-card .card-body { padding: 16px; }
        .article-card .category-badge { background: var(--secondary); color: #fff; font-size: 11px; padding: 2px 10px; border-radius: 3px; text-decoration: none; display: inline-block; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; }
        .article-card .card-title a { color: var(--text-dark); text-decoration: none; font-weight: 600; font-size: 15px; line-height: 1.4; }
        .article-card .card-title a:hover { color: var(--primary); }
        .article-card .card-meta { color: var(--text-muted); font-size: 12px; }
        .sidebar-widget { background: var(--light-bg); border-radius: 6px; padding: 20px; margin-bottom: 25px; }
        .sidebar-widget h5 { color: var(--primary); font-weight: 700; font-size: 16px; border-bottom: 2px solid var(--secondary); padding-bottom: 10px; margin-bottom: 15px; }
        .sidebar-list a { color: var(--text-dark); text-decoration: none; font-size: 14px; display: block; padding: 6px 0; border-bottom: 1px solid var(--border); }
        .sidebar-list a:hover { color: var(--primary); }
        .hero-section { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; padding: 60px 0; }
        .section-header { border-left: 4px solid var(--secondary); padding-left: 12px; margin-bottom: 25px; }
        .section-header h2 { font-size: 22px; font-weight: 700; color: var(--primary); margin: 0; }
        .main-footer { background: var(--text-dark); color: rgba(255,255,255,0.8); padding: 50px 0 20px; }
        .main-footer h6 { color: #fff; font-weight: 700; margin-bottom: 15px; font-size: 14px; text-transform: uppercase; }
        .main-footer a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 13px; display: block; margin-bottom: 6px; }
        .main-footer a:hover { color: #fff; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 30px; font-size: 13px; }
        .page-link { color: var(--primary); }
        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .tag-badge { background: var(--light-bg); color: var(--text-dark); padding: 4px 12px; border-radius: 20px; font-size: 12px; text-decoration: none; display: inline-block; margin: 2px; border: 1px solid var(--border); }
        .tag-badge:hover { background: var(--primary); color: #fff; }
        .navbar-toggler-icon { filter: invert(1); }
        @media (max-width: 768px) { .hero-section { padding: 40px 0; } .main-header .brand { font-size: 20px; } }
    </style>
    @stack('styles')
</head>
<body>

<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div><i class="fas fa-envelope me-1"></i> info@foodindustry.com &nbsp;|&nbsp; <i class="fas fa-phone me-1"></i> +1-800-FOOD-IND</div>
            <div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="me-3"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0" style="color:rgba(255,255,255,0.8);font-size:12px;text-decoration:none;"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="me-3"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    <a href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Register</a>
                @endauth
                &nbsp;|&nbsp;
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="ms-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="ms-2"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>
</div>

<header class="main-header">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <a href="{{ route('home') }}" class="brand d-inline-block" style="line-height:1;">
                    <img src="{{ asset('images/logo-white.svg') }}" alt="Food &amp; Industry" style="height:52px;width:auto;">
                </a>
            </div>
            <div class="col-md-5">
                <form class="search-form d-flex" action="{{ route('articles.index') }}" method="GET">
                    <input type="text" name="search" class="form-control" placeholder="Search news, products, companies..." value="{{ request('search') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('events.index') }}" class="btn btn-sm me-1" style="background:var(--secondary);color:#fff;border:none;"><i class="fas fa-calendar me-1"></i>Events</a>
                <a href="{{ route('companies.index') }}" class="btn btn-sm btn-outline-light"><i class="fas fa-building me-1"></i>Directory</a>
            </div>
        </div>
    </div>
</header>

<nav class="main-nav navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}" data-bs-toggle="dropdown"><i class="fas fa-newspaper me-1"></i>News</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('articles.index') }}">All News</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach(\App\Models\Category::where('type','article')->where('is_active',true)->get() as $cat)
                            <li><a class="dropdown-item" href="{{ route('articles.category', $cat) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="fas fa-box-open me-1"></i>Products</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}" href="{{ route('companies.index') }}"><i class="fas fa-building me-1"></i>Directory</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}"><i class="fas fa-calendar-alt me-1"></i>Events</a></li>
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-0 rounded-0">
    <div class="container">{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show m-0 rounded-0">
    <div class="container">{{ session('error') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@yield('content')

<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div style="margin-bottom:10px;"><img src="{{ asset('images/logo-white.svg') }}" alt="Food &amp; Industry" style="height:44px;width:auto;"></div>
                <p style="font-size:13px;line-height:1.7;">Your trusted source for food and beverage industry news, products, company directory, and events.</p>
                <div class="mt-3">
                    <a href="#" class="btn btn-sm btn-outline-light me-2"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h6>News Topics</h6>
                @foreach(\App\Models\Category::where('type','article')->where('is_active',true)->take(5)->get() as $cat)
                    <a href="{{ route('articles.category', $cat) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="col-md-2 mb-4">
                <h6>Resources</h6>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('companies.index') }}">Directory</a>
                <a href="{{ route('events.index') }}">Events</a>
            </div>
            <div class="col-md-2 mb-4">
                <h6>Company</h6>
                <a href="#">About Us</a>
                <a href="#">Advertise</a>
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="col-md-2 mb-4">
                <h6>Newsletter</h6>
                <p style="font-size:12px;">Get the latest industry news in your inbox.</p>
                <div class="input-group input-group-sm">
                    <input type="email" class="form-control" placeholder="Your email">
                    <button class="btn btn-sm" style="background:var(--secondary);color:#fff;border:none;">Go</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Food &amp; Industry. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
