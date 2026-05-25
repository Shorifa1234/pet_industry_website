@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users Management')
@section('content')
<div class="data-table">
    <div class="table-header">
        <h6><i class="fas fa-users me-2"></i>All Users ({{ $users->total() }})</h6>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add User</a>
    </div>
    <table class="table table-hover">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div style="width:32px;height:32px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;margin-right:10px;flex-shrink:0;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                        <strong>{{ $user->name }}</strong>
                        @if($user->id == auth()->id()) <span style="font-size:10px;color:var(--text-muted);margin-left:4px;">(you)</span>@endif
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-{{ $user->role=='admin'?'danger':($user->role=='editor'?'warning':'secondary') }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->is_active ? '<span class="badge-status-published">Active</span>' : '<span class="badge-status-archived">Inactive</span>' }}</td>
                <td>{{ $user->created_at->format('M j, Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    @if($user->id != auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Delete user?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty<tr><td colspan="6" class="text-center text-muted">No users</td></tr>@endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $users->links() }}</div>
</div>
@endsection
