<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Result\StoreResultRequest;
use App\Http\Requests\SchoolAdmin\Result\UpdateResultRequest;
use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Result;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ResultController extends Controller
{
    public function index()
    {
        return view('school-admin.result.index');
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $examSchedules = ExamSchedule::where('school_id', $schoolId)
            ->with(['exam', 'subject'])
            ->orderBy('exam_date', 'desc')
            ->get()
            ->mapWithKeys(function ($schedule) {
                return [$schedule->id => $schedule->exam->name.' - '.$schedule->subject->name.' ('.$schedule->exam_date->format('d M Y').')'];
            });
        $students = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get()
            ->mapWithKeys(function ($student) {
                return [$student->id => $student->name.' ('.$student->admission_number.')'];
            });
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

        return view('school-admin.result.create', compact('schools', 'academicSessions', 'exams', 'examSchedules', 'students', 'classes', 'sections', 'subjects'));
    }

    public function store(StoreResultRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Calculate percentage if not provided
        if (empty($data['percentage']) && $data['total_marks'] > 0) {
            $data['percentage'] = ($data['obtained_marks'] / $data['total_marks']) * 100;
        }

        // Auto-set grade if not provided
        if (empty($data['grade']) && isset($data['percentage'])) {
            $percentage = $data['percentage'];
            if ($percentage >= 90) {
                $data['grade'] = 'A+';
            } elseif ($percentage >= 80) {
                $data['grade'] = 'A';
            } elseif ($percentage >= 70) {
                $data['grade'] = 'B+';
            } elseif ($percentage >= 60) {
                $data['grade'] = 'B';
            } elseif ($percentage >= 50) {
                $data['grade'] = 'C+';
            } elseif ($percentage >= 40) {
                $data['grade'] = 'C';
            } elseif ($percentage >= 33) {
                $data['grade'] = 'D';
            } else {
                $data['grade'] = 'F';
            }
        }

        // Auto-set status if not provided
        if (empty($data['status']) && isset($data['percentage'])) {
            $data['status'] = $data['percentage'] >= 33 ? 'pass' : 'fail';
        }

        // Set entered_by to current user
        $data['entered_by'] = auth()->id();

        Result::create($data);

        return redirect()->route('school-admin.result.index')
            ->with('success', 'Result created successfully.');
    }

    public function show(Result $result)
    {
        $result->load(['student', 'exam', 'subject', 'academicClass', 'section', 'academicSession', 'examSchedule', 'enteredBy']);

        return view('school-admin.result.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $schoolId = $result->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $examSchedules = ExamSchedule::where('school_id', $schoolId)
            ->with(['exam', 'subject'])
            ->orderBy('exam_date', 'desc')
            ->get()
            ->mapWithKeys(function ($schedule) {
                return [$schedule->id => $schedule->exam->name.' - '.$schedule->subject->name.' ('.$schedule->exam_date->format('d M Y').')'];
            });
        $students = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get()
            ->mapWithKeys(function ($student) {
                return [$student->id => $student->name.' ('.$student->admission_number.')'];
            });
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

        return view('school-admin.result.edit', compact('result', 'schools', 'academicSessions', 'exams', 'examSchedules', 'students', 'classes', 'sections', 'subjects'));
    }

    public function update(UpdateResultRequest $request, Result $result): RedirectResponse
    {
        $data = $request->validated();

        // Calculate percentage if not provided
        if (empty($data['percentage']) && $data['total_marks'] > 0) {
            $data['percentage'] = ($data['obtained_marks'] / $data['total_marks']) * 100;
        }

        // Auto-set grade if not provided
        if (empty($data['grade']) && isset($data['percentage'])) {
            $percentage = $data['percentage'];
            if ($percentage >= 90) {
                $data['grade'] = 'A+';
            } elseif ($percentage >= 80) {
                $data['grade'] = 'A';
            } elseif ($percentage >= 70) {
                $data['grade'] = 'B+';
            } elseif ($percentage >= 60) {
                $data['grade'] = 'B';
            } elseif ($percentage >= 50) {
                $data['grade'] = 'C+';
            } elseif ($percentage >= 40) {
                $data['grade'] = 'C';
            } elseif ($percentage >= 33) {
                $data['grade'] = 'D';
            } else {
                $data['grade'] = 'F';
            }
        }

        // Auto-set status if not provided
        if (empty($data['status']) && isset($data['percentage'])) {
            $data['status'] = $data['percentage'] >= 33 ? 'pass' : 'fail';
        }

        $result->update($data);

        return redirect()->route('school-admin.result.index')
            ->with('success', 'Result updated successfully.');
    }

    public function destroy(Result $result): RedirectResponse
    {
        $result->delete();

        return redirect()->route('school-admin.result.index')
            ->with('success', 'Result deleted successfully.');
    }
}
