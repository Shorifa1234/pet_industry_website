@extends('layouts.admin')
@section('title', 'Events')
@section('page-title', 'Events Management')
@section('content')
<div class="data-table">
    <div class="table-header">
        <h6><i class="fas fa-calendar-alt me-2"></i>All Events ({{ $events->total() }})</h6>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Event</a>
    </div>
    <table class="table table-hover">
        <thead><tr><th>Title</th><th>Type</th><th>Date</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td><strong>{{ Str::limit($event->title, 45) }}</strong></td>
                <td><span class="badge bg-secondary">{{ ucfirst($event->event_type) }}</span></td>
                <td>{{ $event->start_date->format('M j, Y') }}</td>
                <td>{{ $event->city ? $event->city.', '.$event->country : ($event->country ?? '-') }}</td>
                <td><span class="badge-status-{{ $event->status=='upcoming'?'published':($event->status=='past'?'archived':'draft') }}">{{ ucfirst($event->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px;">Edit</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:2px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty<tr><td colspan="6" class="text-center text-muted">No events yet</td></tr>@endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $events->links() }}</div>
</div>
@endsection
