@extends('layouts.admin')
@section('title', 'New Category')
@section('page-title', 'Create New Category')
@section('content')
<div class="form-card" style="max-width:500px;">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3"><label class="form-label">Name *</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" placeholder="Category name...">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Type *</label>
            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">Select Type</option>
                <option value="article" {{ old('type')=='article' ? 'selected' : '' }}>Article/News</option>
                <option value="product" {{ old('type')=='product' ? 'selected' : '' }}>Product</option>
                <option value="event" {{ old('type')=='event' ? 'selected' : '' }}>Event</option>
            </select>
            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2" placeholder="Optional description...">{{ old('description') }}</textarea></div>
        <div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" id="active" class="form-check-input" checked><label for="active" class="form-check-label form-label">Active</label></div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
