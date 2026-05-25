@extends('layouts.app')
@section('title', 'Company Directory - Food & Beverage')
@section('content')
<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        <h1 style="font-size:28px;font-weight:700;margin:0;"><i class="fas fa-building me-2"></i>Company Directory</h1>
        <p style="opacity:0.85;margin:5px 0 0;">Find food & beverage industry companies, suppliers, and manufacturers</p>
    </div>
</div>
<div class="container py-4">
    <form method="GET" action="{{ route('companies.index') }}" class="row g-2 mb-4">
        <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Search companies..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="country" class="form-select">
                <option value="">All Countries</option>
                @foreach($countries as $c)<option value="{{ $c }}" {{ request('country')==$c ? 'selected' : '' }}>{{ $c }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1"><i class="fas fa-search me-1"></i>Search</button>
            <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
    @if($companies->count())
    <div class="row g-3">
        @foreach($companies as $company)
        <div class="col-md-4">
            <div class="article-card">
                <div class="card-body d-flex align-items-start">
                    <div style="width:65px;height:65px;background:var(--light-bg);border-radius:4px;margin-right:15px;flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        @if($company->logo)<img src="{{ asset('storage/'.$company->logo) }}" style="max-width:65px;max-height:65px;object-fit:contain;">
                        @else<i class="fas fa-building fa-2x" style="color:var(--primary);"></i>@endif
                    </div>
                    <div style="flex:1;">
                        <h6 style="margin-bottom:4px;font-weight:700;"><a href="{{ route('companies.show', $company) }}" style="color:var(--text-dark);text-decoration:none;">{{ $company->name }}</a></h6>
                        @if($company->city || $company->country)
                        <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;"><i class="fas fa-map-marker-alt me-1"></i>{{ $company->city }}{{ $company->country ? ($company->city ? ', ' : '') . $company->country : '' }}</div>
                        @endif
                        @if($company->industry_type)<span style="background:var(--light-bg);font-size:11px;padding:2px 8px;border-radius:10px;border:1px solid var(--border);">{{ $company->industry_type }}</span>@endif
                        @if($company->description)<p style="font-size:12px;color:var(--text-muted);margin-top:6px;margin-bottom:0;">{{ Str::limit($company->description, 80) }}</p>@endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $companies->appends(request()->query())->links() }}</div>
    @else
    <div class="text-center py-5"><i class="fas fa-building fa-3x text-muted mb-3"></i><h5 class="text-muted">No companies found</h5></div>
    @endif
</div>
@endsection
