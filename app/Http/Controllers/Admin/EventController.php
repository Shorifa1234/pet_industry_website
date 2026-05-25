<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = \App\Models\Event::latest()->paginate(15);
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
        $data['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . time();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }
        \App\Models\Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function show($id)
    {
        return redirect()->route('admin.events.index');
    }

    public function edit($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'start_date' => 'required|date']);
        $event = \App\Models\Event::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('events', 'public');
        }
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        \App\Models\Event::findOrFail($id)->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
