<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Transportation\StoreTransportationRequest;
use App\Http\Requests\SchoolAdmin\Transportation\UpdateTransportationRequest;
use App\Models\School;
use App\Models\Transportation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('school-admin.transportation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.transportation.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransportationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Transportation::create($data);

        return redirect()->route('school-admin.transportation.index')
            ->with('success', 'Transportation vehicle added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transportation $transportation): View
    {
        $transportation->load('school');

        return view('school-admin.transportation.show', compact('transportation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transportation $transportation): View
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.transportation.edit', compact('transportation', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransportationRequest $request, Transportation $transportation): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $transportation->update($data);

        return redirect()->route('school-admin.transportation.index')
            ->with('success', 'Transportation vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transportation $transportation): RedirectResponse
    {
        $transportation->delete();

        return redirect()->route('school-admin.transportation.index')
            ->with('success', 'Transportation vehicle deleted successfully.');
    }
}
