<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\AcademicSession\StoreAcademicSessionRequest;
use App\Http\Requests\SchoolAdmin\AcademicSession\UpdateAcademicSessionRequest;
use App\Models\AcademicSession;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $academicSessions = \App\Models\AcademicSession::with('school')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('school-admin.academic-session.index', compact('academicSessions'));
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-session.create', compact('schools'));
    }

    public function store(StoreAcademicSessionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_current'] = $request->boolean('is_current', false);

        // If setting as current, unset other current sessions for this school
        if ($data['is_current']) {
            AcademicSession::where('school_id', $data['school_id'])
                ->where('is_current', true)
                ->update(['is_current' => false]);
        }

        AcademicSession::create($data);

        return redirect()->route('school-admin.academic-session.index')
            ->with('success', 'Academic session created successfully.');
    }

    public function show(AcademicSession $academicSession)
    {
        return view('school-admin.academic-session.show', compact('academicSession'));
    }

    public function edit(AcademicSession $academicSession)
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-session.edit', compact('academicSession', 'schools'));
    }

    public function update(UpdateAcademicSessionRequest $request, AcademicSession $academicSession): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);
        $data['is_current'] = $request->boolean('is_current', false);

        // If setting as current, unset other current sessions for this school
        if ($data['is_current']) {
            AcademicSession::where('school_id', $data['school_id'])
                ->where('id', '!=', $academicSession->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);
        }

        $academicSession->update($data);

        return redirect()->route('school-admin.academic-session.index')
            ->with('success', 'Academic session updated successfully.');
    }

    public function destroy(AcademicSession $academicSession): RedirectResponse
    {
        $academicSession->delete();

        return redirect()->route('school-admin.academic-session.index')
            ->with('success', 'Academic session deleted successfully.');
    }
}
