@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add New Product')
@section('content')
<form method="POST" action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($product)) @method('PUT') @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Product Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $product->name ?? '') }}"></div>
                <div class="mb-3"><label class="form-label">Short Description</label><textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description ?? '') }}</textarea></div>
                <div class="mb-3"><label class="form-label">Full Description</label><textarea name="description" class="form-control" rows="8">{{ old('description', $product->description ?? '') }}</textarea></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status',$product->status??'draft')=='draft'?'selected':'' }}>Draft</option>
                        <option value="published" {{ old('status',$product->status??'')=='published'?'selected':'' }}>Published</option>
                        <option value="archived" {{ old('status',$product->status??'')=='archived'?'selected':'' }}>Archived</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">None</option>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id',$product->category_id??'')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Company</label>
                    <select name="company_id" class="form-select">
                        <option value="">None</option>
                        @foreach($companies as $c)<option value="{{ $c->id }}" {{ old('company_id',$product->company_id??'')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand',$product->brand??'') }}"></div>
                <div class="mb-3"><label class="form-label">SKU</label><input type="text" name="sku" class="form-control" value="{{ old('sku',$product->sku??'') }}"></div>
                <div class="mb-3"><label class="form-label">Website URL</label><input type="url" name="website_url" class="form-control" value="{{ old('website_url',$product->website_url??'') }}"></div>
                <div class="form-check mb-3"><input type="checkbox" name="is_featured" value="1" id="feat" class="form-check-input" {{ old('is_featured',$product->is_featured??false)?'checked':'' }}><label for="feat" class="form-check-label form-label">Featured</label></div>
                <div class="mb-3"><label class="form-label">Featured Image</label>
                    @if(isset($product) && $product->featured_image)<img src="{{ asset('storage/'.$product->featured_image) }}" class="img-fluid rounded mb-2" style="width:100%;">@endif
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
