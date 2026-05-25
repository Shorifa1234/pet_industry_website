@extends('layouts.admin')
@section('title', isset($event) ? 'Edit Event' : 'Add Event')
@section('page-title', isset($event) ? 'Edit Event' : 'Add New Event')
@section('content')
<form method="POST" action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($event)) @method('PUT') @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Event Title *</label><input type="text" name="title" class="form-control" required value="{{ old('title',$event->title??'') }}"></div>
                <div class="mb-3"><label class="form-label">Short Description</label><textarea name="short_description" class="form-control" rows="2">{{ old('short_description',$event->short_description??'') }}</textarea></div>
                <div class="mb-3"><label class="form-label">Full Description</label><textarea name="description" class="form-control" rows="8">{{ old('description',$event->description??'') }}</textarea></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-3">
                <div class="mb-3"><label class="form-label">Event Type</label>
                    <select name="event_type" class="form-select">
                        @foreach(['conference','webinar','tradeshow','workshop','summit'] as $type)
                        <option value="{{ $type }}" {{ old('event_type',$event->event_type??'conference')==$type?'selected':'' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Start Date *</label><input type="datetime-local" name="start_date" class="form-control" required value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d\TH:i') : '') }}"></div>
                <div class="mb-3"><label class="form-label">End Date</label><input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', isset($event) && $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}"></div>
                <div class="mb-3"><label class="form-label">Venue</label><input type="text" name="venue" class="form-control" value="{{ old('venue',$event->venue??'') }}"></div>
                <div class="mb-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city',$event->city??'') }}"></div>
                <div class="mb-3"><label class="form-label">Country</label><input type="text" name="country" class="form-control" value="{{ old('country',$event->country??'') }}"></div>
                <div class="mb-3"><label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ old('status',$event->status??'upcoming')=='upcoming'?'selected':'' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status',$event->status??'')=='ongoing'?'selected':'' }}>Ongoing</option>
                        <option value="past" {{ old('status',$event->status??'')=='past'?'selected':'' }}>Past</option>
                        <option value="cancelled" {{ old('status',$event->status??'')=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Organizer</label><input type="text" name="organizer" class="form-control" value="{{ old('organizer',$event->organizer??'') }}"></div>
                <div class="mb-3"><label class="form-label">Registration URL</label><input type="url" name="registration_url" class="form-control" value="{{ old('registration_url',$event->registration_url??'') }}"></div>
                <div class="form-check mb-3"><input type="checkbox" name="is_free" value="1" id="free" class="form-check-input" {{ old('is_free',$event->is_free??true)?'checked':'' }}><label for="free" class="form-check-label form-label">Free Event</label></div>
                <div class="mb-3"><label class="form-label">Featured Image</label>
                    @if(isset($event) && $event->featured_image)<img src="{{ asset('storage/'.$event->featured_image) }}" class="img-fluid rounded mb-2" style="width:100%;">@endif
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Event</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
