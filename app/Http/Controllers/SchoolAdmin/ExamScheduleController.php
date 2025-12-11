<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\ExamSchedule\StoreExamScheduleRequest;
use App\Http\Requests\SchoolAdmin\ExamSchedule\UpdateExamScheduleRequest;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;

class ExamScheduleController extends Controller
{
    public function index()
    {
        return view('school-admin.exam-schedule.index');
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $subjects = Subject::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.exam-schedule.create', compact('schools', 'exams', 'classes', 'sections', 'subjects'));
    }

    public function store(StoreExamScheduleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        ExamSchedule::create($data);

        return redirect()->route('school-admin.exam-schedule.index')
            ->with('success', 'Exam schedule created successfully.');
    }

    public function show(ExamSchedule $examSchedule)
    {
        $examSchedule->load(['exam', 'academicClass', 'section', 'subject', 'school']);

        return view('school-admin.exam-schedule.show', compact('examSchedule'));
    }

    public function edit(ExamSchedule $examSchedule)
    {
        $schoolId = $examSchedule->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $subjects = Subject::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.exam-schedule.edit', compact('examSchedule', 'schools', 'exams', 'classes', 'sections', 'subjects'));
    }

    public function update(UpdateExamScheduleRequest $request, ExamSchedule $examSchedule): RedirectResponse
    {
        $data = $request->validated();

        $examSchedule->update($data);

        return redirect()->route('school-admin.exam-schedule.index')
            ->with('success', 'Exam schedule updated successfully.');
    }

    public function destroy(ExamSchedule $examSchedule): RedirectResponse
    {
        $examSchedule->delete();

        return redirect()->route('school-admin.exam-schedule.index')
            ->with('success', 'Exam schedule deleted successfully.');
    }
}
