@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Article' : 'New Article')
@section('page-title', isset($article) ? 'Edit Article' : 'Create New Article')

@section('content')
<form method="POST" action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($article)) @method('PUT') @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card mb-3">
                <div class="mb-3">
                    <label class="form-label">Article Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" required placeholder="Enter article title...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt / Summary</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Brief summary of the article...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content *</label>
                    <textarea name="content" id="content" class="form-control" rows="15" required>{{ old('content', $article->content ?? '') }}</textarea>
                </div>
            </div>
            <div class="form-card">
                <h6 style="color:var(--primary);margin-bottom:15px;">SEO Settings</h6>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $article->meta_title ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags (comma separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags', $article->tags ?? '') }}" placeholder="food, beverage, industry...">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-3">
                <h6 style="color:var(--primary);margin-bottom:15px;">Publish Settings</h6>
                <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status', $article->status ?? 'draft')=='draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status ?? '')=='published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $article->status ?? '')=='archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Author Name</label>
                    <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $article->author_name ?? auth()->user()->name) }}">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_featured" value="1" id="featured" class="form-check-input" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                    <label for="featured" class="form-check-label form-label">Featured Article</label>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>{{ isset($article) ? 'Update Article' : 'Publish Article' }}</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
            <div class="form-card">
                <h6 style="color:var(--primary);margin-bottom:15px;">Featured Image</h6>
                @if(isset($article) && $article->featured_image)
                    <img src="{{ asset('storage/'.$article->featured_image) }}" class="img-fluid rounded mb-2" style="width:100%;">
                @endif
                <input type="file" name="featured_image" class="form-control" accept="image/*">
                <div style="font-size:11px;color:#7f8c8d;margin-top:4px;">Recommended: 1200x630px</div>
            </div>
        </div>
    </div>
</form>
@endsection
