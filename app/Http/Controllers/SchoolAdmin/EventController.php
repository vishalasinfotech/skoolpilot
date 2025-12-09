<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Event\StoreEventRequest;
use App\Http\Requests\SchoolAdmin\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index()
    {
        return view('school-admin.event.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.event.create', compact('schools'));
    }

    public function show(Event $event)
    {
        return view('school-admin.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.event.edit', compact('event', 'schools'));
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Event::create($data);

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event created successfully.');
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $event->update($data);

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event deleted successfully.');
    }
}
