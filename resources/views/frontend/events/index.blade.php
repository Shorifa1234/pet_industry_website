@extends('layouts.app')
@section('title', 'Industry Events - Food & Beverage')
@section('content')
<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        <h1 style="font-size:28px;font-weight:700;margin:0;"><i class="fas fa-calendar-alt me-2"></i>Industry Events</h1>
        <p style="opacity:0.85;margin:5px 0 0;">Conferences, Trade Shows, Webinars & Workshops</p>
    </div>
</div>
<div class="container py-4">
    <div class="mb-4 d-flex gap-2 flex-wrap">
        <a href="{{ route('events.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">All Events</a>
        <a href="{{ route('events.index', ['filter'=>'upcoming']) }}" class="btn btn-sm {{ request('filter')=='upcoming' ? 'btn-primary' : 'btn-outline-primary' }}">Upcoming</a>
        <a href="{{ route('events.index', ['filter'=>'past']) }}" class="btn btn-sm {{ request('filter')=='past' ? 'btn-primary' : 'btn-outline-primary' }}">Past Events</a>
        &nbsp;|&nbsp;
        <a href="{{ route('events.index', ['type'=>'conference']) }}" class="btn btn-sm {{ request('type')=='conference' ? 'btn-secondary' : 'btn-outline-secondary' }}">Conferences</a>
        <a href="{{ route('events.index', ['type'=>'webinar']) }}" class="btn btn-sm {{ request('type')=='webinar' ? 'btn-secondary' : 'btn-outline-secondary' }}">Webinars</a>
        <a href="{{ route('events.index', ['type'=>'tradeshow']) }}" class="btn btn-sm {{ request('type')=='tradeshow' ? 'btn-secondary' : 'btn-outline-secondary' }}">Trade Shows</a>
    </div>
    @if($events->count())
    <div class="row g-3">
        @foreach($events as $event)
        <div class="col-md-6">
            <div class="article-card">
                <div class="card-body">
                    <div class="d-flex">
                        <div style="background:var(--primary);color:#fff;text-align:center;padding:10px 15px;border-radius:6px;margin-right:15px;flex-shrink:0;min-width:60px;">
                            <div style="font-size:22px;font-weight:700;line-height:1;">{{ $event->start_date->format('d') }}</div>
                            <div style="font-size:11px;text-transform:uppercase;">{{ $event->start_date->format('M Y') }}</div>
                        </div>
                        <div style="flex:1;">
                            <div class="mb-1">
                                <span style="background:{{ $event->event_type=='webinar' ? '#27ae60' : ($event->event_type=='tradeshow' ? '#8e44ad' : 'var(--secondary)') }};color:#fff;font-size:10px;padding:2px 8px;border-radius:3px;font-weight:700;text-transform:uppercase;">{{ $event->event_type }}</span>
                                @if($event->is_free)<span style="background:#27ae60;color:#fff;font-size:10px;padding:2px 8px;border-radius:3px;margin-left:4px;">FREE</span>@endif
                            </div>
                            <h6 style="font-weight:700;margin-bottom:4px;"><a href="{{ route('events.show', $event) }}" style="color:var(--text-dark);text-decoration:none;">{{ $event->title }}</a></h6>
                            @if($event->city || $event->country)<div style="font-size:12px;color:var(--text-muted);"><i class="fas fa-map-marker-alt me-1"></i>{{ $event->city }}{{ $event->country ? ', '.$event->country : '' }}</div>@endif
                            @if($event->organizer)<div style="font-size:12px;color:var(--text-muted);"><i class="fas fa-user me-1"></i>{{ $event->organizer }}</div>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $events->appends(request()->query())->links() }}</div>
    @else
    <div class="text-center py-5"><i class="fas fa-calendar fa-3x text-muted mb-3"></i><h5 class="text-muted">No events found</h5></div>
    @endif
</div>
@endsection
