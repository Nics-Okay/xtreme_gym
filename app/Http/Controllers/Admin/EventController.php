<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function show()
    {
        $today = now(); // Get the current date and time

        // Fetch upcoming events (date is after today) sorted by soonest date first
        $upcomingEvents = Event::where('date', '>', $today)
            ->orWhereNull('date')
            ->orderByRaw('ISNULL(date), date ASC')
            ->get();
    
        // Fetch completed events (date is before or equal to today) sorted by latest completed first
        $completedEvents = Event::where('date', '<=', $today)
            ->orderBy('date', 'desc')
            ->get();
    
        return view('admin.events.events', [
            'upcomingEvents' => $upcomingEvents,
            'completedEvents' => $completedEvents,
        ]);
    }

    public function edit(Event $event) {
        return view('admin.events.editEvent', ['event' => $event]);
    }

    public function create(){
        return view('admin.events.createEvent');
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'event_type' => 'required|string|max:100',
            'date' => 'nullable|date|date_format:Y-m-d|after:today',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('equipment_images', 'public');
        }

        Event::create([
            'name' => $validated['name'],
            'event_type' => $validated['event_type'],
            'date' => $validated['date'] ?? null,
            'location' => $validated['location'] ?? null,
            'organizer' => $validated['organizer'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('event.show')->with('success', 'Event created successfully.');
    }

    public function update(Request $request, Event $event)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'event_type' => 'required|string|max:100',
            'date' => 'nullable|date|date_format:Y-m-d|after:today',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('thumbnail')->store('equipment_images', 'public');
        } else {
            $imagePath = $event->image;
        }

        $event->update([
            'name' => $validated['name'],
            'event_type' => $validated['event_type'],
            'date' => $validated['date'] ?? null,
            'location' => $validated['location'] ?? null,
            'organizer' => $validated['organizer'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('event.show')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event) {
        $event->delete();
        return redirect(route('event.show'))->with('success', 'Event Deleted Successfully');
    }
}
