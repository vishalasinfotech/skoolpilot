<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Holiday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('school-admin.calendar.index');
    }

    public function getEvents(Request $request): JsonResponse
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $events = Event::where('is_active', true)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where(function ($subQ) use ($end) {
                                $subQ->whereNull('end_date')
                                    ->orWhere('end_date', '>=', $end);
                            });
                    });
            })
            ->get()
            ->map(function ($event) {
                $startDate = $event->start_date->format('Y-m-d');
                $startDateTime = $startDate.($event->start_time ? 'T'.$event->start_time : '');

                $endDate = $event->end_date
                    ? $event->end_date->format('Y-m-d').($event->end_time ? 'T'.$event->end_time : '')
                    : ($event->start_time ? null : $startDate);

                return [
                    'id' => 'event-'.$event->id,
                    'title' => $event->title,
                    'start' => $startDateTime,
                    'end' => $endDate,
                    'allDay' => ! $event->start_time && ! $event->end_time,
                    'color' => '#0ab39c',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'type' => 'event',
                        'description' => $event->description,
                        'location' => $event->location,
                        'start_time' => $event->start_time,
                        'end_time' => $event->end_time,
                        'url' => route('school-admin.event.show', $event->id),
                    ],
                ];
            });

        $holidays = Holiday::where('is_active', true)
            ->whereBetween('date', [$start, $end])
            ->get()
            ->map(function ($holiday) {
                return [
                    'id' => 'holiday-'.$holiday->id,
                    'title' => $holiday->name,
                    'start' => $holiday->date->format('Y-m-d'),
                    'allDay' => true,
                    'color' => '#f06548',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'type' => 'holiday',
                        'description' => $holiday->description,
                        'url' => route('school-admin.holiday.show', $holiday->id),
                    ],
                ];
            });

        return response()->json($events->merge($holidays)->values());
    }
}
