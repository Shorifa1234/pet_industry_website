@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products Management')
@section('content')
<div class="data-table">
    <div class="table-header">
        <h6><i class="fas fa-box-open me-2"></i>All Products ({{ $products->total() }})</h6>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Product</a>
    </div>
    <table class="table table-hover">
        <thead><tr><th>Name</th><th>Category</th><th>Company</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td><strong>{{ Str::limit($product->name, 50) }}</strong></td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>{{ $product->company?->name ?? '-' }}</td>
                <td><span class="badge-status-{{ $product->status }}">{{ ucfirst($product->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">No products yet</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $products->links() }}</div>
</div>
@endsection
