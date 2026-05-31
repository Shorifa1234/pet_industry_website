@extends('layouts.admin')
@section('title', 'View Company')
@section('page-title', 'Company Details')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card mb-3">
            <div class="d-flex align-items-center gap-3 mb-3">
                @if($company->logo)
                    <img src="{{ asset('storage/'.$company->logo) }}" style="width:70px;height:70px;object-fit:contain;border-radius:8px;border:1px solid #eee;">
                @endif
                <div>
                    <h5 style="margin:0;">{{ $company->name }}</h5>
                    <span class="badge-status-{{ $company->status=='active'?'published':($company->status=='inactive'?'archived':'draft') }}">{{ ucfirst($company->status) }}</span>
                    @if($company->is_featured) <span style="background:#ffc107;color:#000;font-size:11px;padding:2px 8px;border-radius:4px;margin-left:4px;">Featured</span> @endif
                </div>
            </div>
            @if($company->description)
                <p style="color:#555;line-height:1.7;">{{ $company->description }}</p>
            @endif
        </div>

        @if($products->count())
        <div class="form-card">
            <h6 style="color:var(--primary);margin-bottom:15px;"><i class="fas fa-box me-2"></i>Products ({{ $products->count() }})</h6>
            <table class="table table-hover" style="font-size:13px;">
                <thead><tr><th>Name</th><th>Category</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name ?? '-' }}</td>
                        <td><span class="badge-status-{{ $product->status }}">{{ ucfirst($product->status) }}</span></td>
                        <td><a href="{{ route('admin.products.edit', $product) }}" style="font-size:11px;">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="col-lg-4">
        <div class="form-card mb-3">
            <h6 style="color:var(--primary);margin-bottom:15px;">Company Info</h6>
            <table class="table table-sm table-borderless" style="font-size:13px;">
                <tr><td class="text-muted">Industry</td><td>{{ $company->industry_type ?? '-' }}</td></tr>
                <tr><td class="text-muted">Website</td><td>@if($company->website)<a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>@else -@endif</td></tr>
                <tr><td class="text-muted">Email</td><td>{{ $company->email ?? '-' }}</td></tr>
                <tr><td class="text-muted">Phone</td><td>{{ $company->phone ?? '-' }}</td></tr>
                <tr><td class="text-muted">City</td><td>{{ $company->city ?? '-' }}</td></tr>
                <tr><td class="text-muted">Country</td><td>{{ $company->country ?? '-' }}</td></tr>
                <tr><td class="text-muted">Added</td><td>{{ $company->created_at->format('M j, Y') }}</td></tr>
            </table>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Company</a>
            @if($company->status == 'active')
                <a href="{{ route('companies.show', $company) }}" target="_blank" class="btn btn-outline-success"><i class="fas fa-external-link-alt me-2"></i>View on Site</a>
            @endif
            <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
