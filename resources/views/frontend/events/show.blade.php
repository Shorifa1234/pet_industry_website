@extends('layouts.app')
@section('title', $event->title . ' | Food & Industry Events')
@section('meta_description', Str::limit(strip_tags($event->short_description ?? $event->description ?? $event->title . ' - ' . $event->start_date->format('F j, Y') . ($event->city ? ', '.$event->city : '')), 160))
@section('meta_keywords', $event->title . ', food industry event, beverage event, ' . ($event->event_type ?? 'F&B event') . ($event->city ? ', '.$event->city : ''))
@section('canonical', route('events.show', $event))
@section('og_title', $event->title)
@section('og_description', Str::limit(strip_tags($event->short_description ?? $event->description ?? ''), 200))
@section('og_image', $event->featured_image ? asset('storage/'.$event->featured_image) : asset('images/logo.svg'))

@push('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "{{ addslashes($event->title) }}",
  "startDate": "{{ $event->start_date->toIso8601String() }}"
  @if($event->end_date),"endDate": "{{ $event->end_date->toIso8601String() }}"@endif
  @if($event->short_description ?? $event->description),"description": "{{ addslashes(Str::limit(strip_tags($event->short_description ?? $event->description), 300)) }}"@endif
  @if($event->featured_image),"image": "{{ asset('storage/'.$event->featured_image) }}"@endif
  ,"url": "{{ route('events.show', $event) }}"
  ,"eventStatus": "{{ $event->status === 'cancelled' ? 'https://schema.org/EventCancelled' : 'https://schema.org/EventScheduled' }}"
  ,"eventAttendanceMode": "{{ ($event->event_type === 'webinar' || $event->event_type === 'virtual') ? 'https://schema.org/OnlineEventAttendanceMode' : 'https://schema.org/OfflineEventAttendanceMode' }}"
  @if($event->venue || $event->city),"location": {
    "@type": "{{ ($event->event_type === 'webinar' || $event->event_type === 'virtual') ? 'VirtualLocation' : 'Place' }}"
    @if($event->venue),"name": "{{ addslashes($event->venue) }}"@endif
    @if($event->city),"address": {
      "@type": "PostalAddress",
      "addressLocality": "{{ addslashes($event->city) }}"
      @if($event->country),"addressCountry": "{{ addslashes($event->country) }}"@endif
    }@endif
  }@endif
  @if($event->organizer),"organizer": { "@type": "Organization", "name": "{{ addslashes($event->organizer) }}" }@endif
  ,"offers": {
    "@type": "Offer",
    "price": "{{ $event->is_free ? '0' : $event->price }}",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
    @if($event->registration_url),"url": "{{ $event->registration_url }}"@endif
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
    { "@type": "ListItem", "position": 2, "name": "Events", "item": "{{ route('events.index') }}" },
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($event->title) }}" }
  ]
}
</script>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div style="background:var(--light-bg);border-bottom:1px solid var(--border);padding:8px 0;font-size:12px;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <a href="{{ route('home') }}" style="color:var(--primary);text-decoration:none;">Home</a>
            <span class="mx-1 text-muted">/</span>
            <a href="{{ route('events.index') }}" style="color:var(--primary);text-decoration:none;">Events</a>
            <span class="mx-1 text-muted">/</span>
            <span class="text-muted">{{ Str::limit($event->title, 50) }}</span>
        </nav>
    </div>
</div>
<div style="background:var(--primary);color:#fff;padding:25px 0;">
    <div class="container">
        <span style="background:var(--secondary);color:#fff;font-size:11px;padding:3px 12px;border-radius:3px;text-transform:uppercase;font-weight:700;">{{ $event->event_type }}</span>
        <h1 style="font-size:26px;font-weight:700;margin:10px 0 5px;">{{ $event->title }}</h1>
        <div style="font-size:13px;opacity:0.85;">
            <i class="fas fa-calendar me-1"></i>{{ $event->start_date->format('F j, Y') }}
            @if($event->end_date) &ndash; {{ $event->end_date->format('F j, Y') }} @endif
            @if($event->city || $event->country) &nbsp;|&nbsp; <i class="fas fa-map-marker-alt me-1"></i>{{ $event->city }}{{ $event->country ? ', '.$event->country : '' }} @endif
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            @if($event->featured_image)<img src="{{ asset('storage/'.$event->featured_image) }}" class="img-fluid rounded mb-4" style="width:100%;max-height:400px;object-fit:cover;" alt="{{ $event->title }}">@endif
            <div style="font-size:15px;line-height:1.8;">{!! $event->description ?? $event->short_description !!}</div>
        </div>
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <h5><i class="fas fa-info-circle me-2"></i>Event Details</h5>
                <table class="table table-sm" style="font-size:13px;">
                    <tr><td style="color:var(--text-muted);width:40%;">Date</td><td><strong>{{ $event->start_date->format('M j, Y') }}</strong></td></tr>
                    @if($event->end_date)<tr><td style="color:var(--text-muted);">End Date</td><td>{{ $event->end_date->format('M j, Y') }}</td></tr>@endif
                    @if($event->venue)<tr><td style="color:var(--text-muted);">Venue</td><td>{{ $event->venue }}</td></tr>@endif
                    @if($event->city)<tr><td style="color:var(--text-muted);">Location</td><td>{{ implode(', ', array_filter([$event->city, $event->country])) }}</td></tr>@endif
                    @if($event->organizer)<tr><td style="color:var(--text-muted);">Organizer</td><td>{{ $event->organizer }}</td></tr>@endif
                    <tr><td style="color:var(--text-muted);">Fee</td><td>{{ $event->is_free ? '<span class="badge bg-success">FREE</span>' : '$'.number_format($event->price,2) }}</td></tr>
                </table>
                @if($event->registration_url)
                <a href="{{ $event->registration_url }}" target="_blank" class="btn btn-primary w-100"><i class="fas fa-user-plus me-2"></i>Register Now</a>
                @endif
                @if($event->website_url)
                <a href="{{ $event->website_url }}" target="_blank" class="btn btn-outline-primary w-100 mt-2"><i class="fas fa-external-link-alt me-2"></i>Event Website</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
