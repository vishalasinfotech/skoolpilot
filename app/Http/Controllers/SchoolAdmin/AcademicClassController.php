<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\AcademicClass\StoreAcademicClassRequest;
use App\Http\Requests\SchoolAdmin\AcademicClass\UpdateAcademicClassRequest;
use App\Models\AcademicClass;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class AcademicClassController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', AcademicClass::class);

        return view('school-admin.academic-class.index');
    }

    public function create()
    {
        $this->authorize('create', AcademicClass::class);
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-class.create', compact('schools'));
    }

    public function show(AcademicClass $academicClass)
    {
        $this->authorize('view', $academicClass);

        return view('school-admin.academic-class.show', compact('academicClass'));
    }

    public function edit(AcademicClass $academicClass)
    {
        $this->authorize('update', $academicClass);
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-class.edit', compact('academicClass', 'schools'));
    }

    public function store(StoreAcademicClassRequest $request): RedirectResponse
    {
        $this->authorize('create', AcademicClass::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;

        AcademicClass::create($data);

        return redirect()->route('school-admin.academic-class.index')
            ->with('success', 'Academic class created successfully.');
    }

    public function update(UpdateAcademicClassRequest $request, AcademicClass $academicClass): RedirectResponse
    {
        $this->authorize('update', $academicClass);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $academicClass->update($data);

        return redirect()->route('school-admin.academic-class.index')
            ->with('success', 'Academic class updated successfully.');
    }

    public function destroy(AcademicClass $academicClass): RedirectResponse
    {
        $this->authorize('delete', $academicClass);
        $academicClass->delete();

        return redirect()->route('school-admin.academic-class.index')
            ->with('success', 'Academic class deleted successfully.');
    }
}
