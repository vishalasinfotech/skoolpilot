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
        $this->authorize('viewAny', AcademicSession::class);

        return view('school-admin.academic-session.index');
    }

    public function create()
    {
        $this->authorize('create', AcademicSession::class);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-session.create', compact('schools'));
    }

    public function store(StoreAcademicSessionRequest $request): RedirectResponse
    {
        $this->authorize('create', AcademicSession::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_current'] = $request->boolean('is_current', false);
        $data['school_id'] = auth()->user()->school_id;
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
        $this->authorize('view', $academicSession);

        return view('school-admin.academic-session.show', compact('academicSession'));
    }

    public function edit(AcademicSession $academicSession)
    {
        $this->authorize('update', $academicSession);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.academic-session.edit', compact('academicSession', 'schools'));
    }

    public function update(UpdateAcademicSessionRequest $request, AcademicSession $academicSession): RedirectResponse
    {
        $this->authorize('update', $academicSession);
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
        $this->authorize('delete', $academicSession);
        $academicSession->delete();

        return redirect()->route('school-admin.academic-session.index')
            ->with('success', 'Academic session deleted successfully.');
    }
}
