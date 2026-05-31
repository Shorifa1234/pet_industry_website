<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'start_date' => 'required|date']);
        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . time();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate(['title' => 'required|string|max:255', 'start_date' => 'required|date']);
        $data = $request->all();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
