<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', '!=', 'cancelled');

        if ($request->type) {
            $query->where('event_type', $request->type);
        }
        if ($request->filter === 'upcoming') {
            $query->where('start_date', '>=', now());
        } elseif ($request->filter === 'past') {
            $query->where('start_date', '<', now());
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(12);

        return view('frontend.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('frontend.events.show', compact('event'));
    }
}
