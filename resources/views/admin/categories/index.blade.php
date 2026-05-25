@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories Management')
@section('content')
<div class="row">
<div class="col-md-4">
<div class="form-card">
    <h6 style="color:var(--primary);margin-bottom:15px;font-weight:700;"><i class="fas fa-plus me-2"></i>Add Category</h6>
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
        <div class="mb-3"><label class="form-label">Type *</label>
            <select name="type" class="form-select">
                <option value="article" {{ old('type')=='article' ? 'selected' : '' }}>Article/News</option>
                <option value="product" {{ old('type')=='product' ? 'selected' : '' }}>Product</option>
                <option value="event" {{ old('type')=='event' ? 'selected' : '' }}>Event</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
        <div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" id="active" class="form-check-input" checked><label for="active" class="form-check-label form-label">Active</label></div>
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-2"></i>Save Category</button>
    </form>
</div>
</div>
<div class="col-md-8">
<div class="data-table">
    <div class="table-header"><h6><i class="fas fa-tags me-2"></i>All Categories ({{ $categories->total() }})</h6></div>
    <table class="table table-hover">
        <thead><tr><th>Name</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td><strong>{{ $cat->name }}</strong></td>
                <td><span class="badge bg-secondary">{{ ucfirst($cat->type) }}</span></td>
                <td>{{ $cat->is_active ? '<span class="badge-status-published">Active</span>' : '<span class="badge-status-archived">Inactive</span>' }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">No categories yet</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $categories->links() }}</div>
</div>
</div>
</div>
@endsection
