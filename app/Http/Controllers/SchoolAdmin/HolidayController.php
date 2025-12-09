<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Holiday\StoreHolidayRequest;
use App\Http\Requests\SchoolAdmin\Holiday\UpdateHolidayRequest;
use App\Models\Holiday;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class HolidayController extends Controller
{
    public function index()
    {
        return view('school-admin.holiday.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.holiday.create', compact('schools'));
    }

    public function show(Holiday $holiday)
    {
        return view('school-admin.holiday.show', compact('holiday'));
    }

    public function edit(Holiday $holiday)
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.holiday.edit', compact('holiday', 'schools'));
    }

    public function store(StoreHolidayRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Holiday::create($data);

        return redirect()->route('school-admin.holiday.index')
            ->with('success', 'Holiday created successfully.');
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $holiday->update($data);

        return redirect()->route('school-admin.holiday.index')
            ->with('success', 'Holiday updated successfully.');
    }

    public function destroy(Holiday $holiday): RedirectResponse
    {
        $holiday->delete();

        return redirect()->route('school-admin.holiday.index')
            ->with('success', 'Holiday deleted successfully.');
    }
}
