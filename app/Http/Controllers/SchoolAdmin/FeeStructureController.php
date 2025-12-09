<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\FeeStructure\StoreFeeStructureRequest;
use App\Http\Requests\SchoolAdmin\FeeStructure\UpdateFeeStructureRequest;
use App\Models\AcademicClass;
use App\Models\FeeStructure;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('school-admin.fee-structure.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', auth()->user()->school_id)
            ->where('deleted_at', null)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.fee-structure.create', compact('schools', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeStructureRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        FeeStructure::create($data);

        return redirect()->route('school-admin.fee-structure.index')
            ->with('success', 'Fee structure created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeStructure $feeStructure)
    {
        return view('school-admin.fee-structure.show', compact('feeStructure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeStructure $feeStructure)
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', $feeStructure->school_id)
            ->where('deleted_at', null)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.fee-structure.edit', compact('feeStructure', 'schools', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeStructureRequest $request, FeeStructure $feeStructure): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $feeStructure->update($data);

        return redirect()->route('school-admin.fee-structure.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeStructure $feeStructure): RedirectResponse
    {
        $feeStructure->delete();

        return redirect()->route('school-admin.fee-structure.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}
