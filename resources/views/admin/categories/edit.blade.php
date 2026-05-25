@extends('layouts.admin')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('content')
<div class="form-card" style="max-width:500px;">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}"></div>
        <div class="mb-3"><label class="form-label">Type *</label>
            <select name="type" class="form-select">
                <option value="article" {{ old('type',$category->type)=='article' ? 'selected' : '' }}>Article/News</option>
                <option value="product" {{ old('type',$category->type)=='product' ? 'selected' : '' }}>Product</option>
                <option value="event" {{ old('type',$category->type)=='event' ? 'selected' : '' }}>Event</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description',$category->description) }}</textarea></div>
        <div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" id="active" class="form-check-input" {{ $category->is_active ? 'checked' : '' }}><label for="active" class="form-check-label form-label">Active</label></div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
