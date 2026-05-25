@extends('layouts.admin')
@section('title', 'Companies')
@section('page-title', 'Companies Directory Management')
@section('content')
<div class="data-table">
    <div class="table-header">
        <h6><i class="fas fa-building me-2"></i>All Companies ({{ $companies->total() }})</h6>
        <a href="{{ route('admin.companies.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Company</a>
    </div>
    <table class="table table-hover">
        <thead><tr><th>Name</th><th>Country</th><th>Industry</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($companies as $company)
            <tr>
                <td><strong>{{ $company->name }}</strong>@if($company->is_featured) <span style="background:#ffc107;color:#000;font-size:10px;padding:1px 6px;border-radius:3px;">Featured</span>@endif</td>
                <td>{{ $company->country ?? '-' }}</td>
                <td>{{ $company->industry_type ?? '-' }}</td>
                <td><span class="badge-status-{{ $company->status=='active'?'published':($company->status=='inactive'?'archived':'draft') }}">{{ ucfirst($company->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty<tr><td colspan="5" class="text-center text-muted">No companies yet</td></tr>@endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $companies->links() }}</div>
</div>
@endsection
