<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\ExamSchedule\StoreExamScheduleRequest;
use App\Http\Requests\SchoolAdmin\ExamSchedule\UpdateExamScheduleRequest;
use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Result;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
        $data['school_id'] = auth()->user()->school_id;

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

    /**
     * Display exam schedules and results for logged-in student.
     */
    public function studentIndex(): View
    {
        $student = auth()->user();
        $schoolId = $student->school_id;
        $classId = $student->class_id;
        $sectionId = $student->section_id;

        // Get exam schedules for the student's class and section
        $examSchedules = ExamSchedule::where('school_id', $schoolId)
            ->where('academic_class_id', $classId)
            ->when($sectionId, function ($query) use ($sectionId) {
                return $query->where('section_id', $sectionId);
            })
            ->with(['exam', 'subject', 'academicClass', 'section'])
            ->orderBy('exam_date', 'asc')
            ->get();

        // Get results for the student
        $results = Result::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->with(['exam', 'subject', 'academicClass', 'academicSession'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.exam-schedule-results', compact('examSchedules', 'results'));
    }
}
