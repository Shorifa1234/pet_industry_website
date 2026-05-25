@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Add User')
@section('page-title', isset($user) ? 'Edit User' : 'Add New User')
@section('content')
<div class="form-card" style="max-width:600px;">
    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf @if(isset($user)) @method('PUT') @endif
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name',$user->name??'') }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email',$user->email??'') }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Password {{ isset($user) ? '(leave blank to keep)' : '*' }}</label><input type="password" name="password" class="form-control" {{ !isset($user)?'required':'' }}></div>
            <div class="col-md-6 mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Role *</label>
                <select name="role" class="form-select">
                    <option value="user" {{ old('role',$user->role??'user')=='user'?'selected':'' }}>User</option>
                    <option value="editor" {{ old('role',$user->role??'')=='editor'?'selected':'' }}>Editor</option>
                    <option value="admin" {{ old('role',$user->role??'')=='admin'?'selected':'' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-6 mb-3"><label class="form-label">Company</label><input type="text" name="company" class="form-control" value="{{ old('company',$user->company??'') }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone??'') }}"></div>
            @if(isset($user))
            <div class="col-md-6 mb-3 d-flex align-items-end">
                <div class="form-check"><input type="checkbox" name="is_active" value="1" id="active" class="form-check-input" {{ old('is_active',$user->is_active??true)?'checked':'' }}><label for="active" class="form-check-label form-label">Account Active</label></div>
            </div>
            @endif
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>{{ isset($user)?'Update User':'Create User' }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
