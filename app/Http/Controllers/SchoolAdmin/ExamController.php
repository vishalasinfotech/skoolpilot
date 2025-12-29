<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Exam\StoreExamRequest;
use App\Http\Requests\SchoolAdmin\Exam\UpdateExamRequest;
use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\School;
use Illuminate\Http\RedirectResponse;

class ExamController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Exam::class);

        return view('school-admin.exam.index');
    }

    public function create()
    {
        $this->authorize('create', Exam::class);

        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('school-admin.exam.create', compact('schools', 'academicSessions'));
    }

    public function store(StoreExamRequest $request): RedirectResponse
    {
        $this->authorize('create', Exam::class);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;
        Exam::create($data);

        return redirect()->route('school-admin.exam.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);

        $exam->load(['school', 'academicSession']);

        return view('school-admin.exam.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', $exam->school_id)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('school-admin.exam.edit', compact('exam', 'schools', 'academicSessions'));
    }

    public function update(UpdateExamRequest $request, Exam $exam): RedirectResponse
    {
        $this->authorize('update', $exam);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $exam->update($data);

        return redirect()->route('school-admin.exam.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam): RedirectResponse
    {
        $this->authorize('delete', $exam);

        $exam->delete();

        return redirect()->route('school-admin.exam.index')
            ->with('success', 'Exam deleted successfully.');
    }
}
