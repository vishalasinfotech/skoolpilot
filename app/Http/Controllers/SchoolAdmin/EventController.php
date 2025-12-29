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
        $this->authorize('viewAny', Event::class);

        return view('school-admin.event.index');
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        $schools = School::whereNull('deleted_at')->where('status', true)->pluck('name', 'id');

        return view('school-admin.event.create', compact('schools'));
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return view('school-admin.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $schools = School::whereNull('deleted_at')->where('status', true)->pluck('name', 'id');

        return view('school-admin.event.edit', compact('event', 'schools'));
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;
        Event::create($data);

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event created successfully.');
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $event->update($data);

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect()->route('school-admin.event.index')
            ->with('success', 'Event deleted successfully.');
    }
}
