@extends('layouts.admin')
@section('title', isset($company) ? 'Edit Company' : 'Add Company')
@section('page-title', isset($company) ? 'Edit Company' : 'Add New Company')
@section('content')
<form method="POST" action="{{ isset($company) ? route('admin.companies.update', $company) : route('admin.companies.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($company)) @method('PUT') @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Company Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name',$company->name??'') }}"></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="6">{{ old('description',$company->description??'') }}</textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Website</label><input type="url" name="website" class="form-control" value="{{ old('website',$company->website??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$company->email??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$company->phone??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Industry Type</label><input type="text" name="industry_type" class="form-control" value="{{ old('industry_type',$company->industry_type??'') }}" placeholder="e.g. Ingredients, Packaging..."></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Address</label><input type="text" name="address" class="form-control" value="{{ old('address',$company->address??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city',$company->city??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Country</label><input type="text" name="country" class="form-control" value="{{ old('country',$company->country??'') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">State</label><input type="text" name="state" class="form-control" value="{{ old('state',$company->state??'') }}"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status',$company->status??'active')=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status',$company->status??'')=='inactive'?'selected':'' }}>Inactive</option>
                        <option value="pending" {{ old('status',$company->status??'')=='pending'?'selected':'' }}>Pending</option>
                    </select>
                </div>
                <div class="form-check mb-3"><input type="checkbox" name="is_featured" value="1" id="feat" class="form-check-input" {{ old('is_featured',$company->is_featured??false)?'checked':'' }}><label for="feat" class="form-check-label form-label">Featured</label></div>
                <div class="mb-3"><label class="form-label">Logo</label>
                    @if(isset($company) && $company->logo)<img src="{{ asset('storage/'.$company->logo) }}" class="img-fluid rounded mb-2" style="max-height:80px;">@endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Company</button>
                    <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
