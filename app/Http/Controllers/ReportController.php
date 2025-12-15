<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\Attendance;
use App\Models\BookIssue;
use App\Models\Exam;
use App\Models\Result;
use App\Models\School;
use App\Models\Section;
use App\Models\StudentFeeTransaction;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display reports index page based on user role.
     */
    public function index(): View
    {
        $user = auth()->user();
        $role = $user->role;

        return view('reports.index', compact('role', 'user'));
    }

    // ==================== SUPER ADMIN REPORTS ====================

    /**
     * Revenue Report - Super Admin
     */
    public function revenue(Request $request): View
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $status = $request->get('status', 'all');

        $query = Transaction::query()
            ->whereBetween('created_at', [$startDate, $endDate.' 23:59:59'])
            ->with(['school', 'subscriptionPlan']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $transactions->where('status', 'completed')->sum('amount');
        $totalPending = $transactions->where('status', 'pending')->sum('amount');
        $totalFailed = $transactions->where('status', 'failed')->sum('amount');

        return view('reports.super-admin.revenue', compact(
            'transactions',
            'totalRevenue',
            'totalPending',
            'totalFailed',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Schools Report - Super Admin
     */
    public function schools(Request $request): View
    {
        $status = $request->get('status', 'all');

        $query = School::with(['subscriptionPlan', 'transactions']);

        if ($status === 'active') {
            $query->where('status', true);
        } elseif ($status === 'inactive') {
            $query->where('status', false);
        }

        $schools = $query->orderBy('created_at', 'desc')->get();
        $totalSchools = School::count();
        $activeSchools = School::where('status', true)->count();
        $inactiveSchools = School::where('status', false)->count();

        return view('reports.super-admin.schools', compact(
            'schools',
            'totalSchools',
            'activeSchools',
            'inactiveSchools',
            'status'
        ));
    }

    /**
     * Transactions Report - Super Admin
     */
    public function transactions(Request $request): View
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $schoolId = $request->get('school_id');

        $query = Transaction::query()
            ->whereBetween('created_at', [$startDate, $endDate.' 23:59:59'])
            ->with(['school', 'subscriptionPlan']);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        $schools = School::where('status', true)->orderBy('name')->pluck('name', 'id');

        return view('reports.super-admin.transactions', compact(
            'transactions',
            'schools',
            'startDate',
            'endDate',
            'schoolId'
        ));
    }

    // ==================== SCHOOL ADMIN REPORTS ====================

    /**
     * Student Report - School Admin
     */
    public function students(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');
        $status = $request->get('status', 'all');

        $query = User::query()
            ->students()
            ->where('school_id', $schoolId)
            ->with(['academicClass', 'section']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $students = $query->orderBy('first_name')->get();
        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('reports.school-admin.students', compact(
            'students',
            'classes',
            'sections',
            'classId',
            'sectionId',
            'status'
        ));
    }

    /**
     * Teacher Report - School Admin
     */
    public function teachers(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $status = $request->get('status', 'all');

        $query = User::query()
            ->teachers()
            ->where('school_id', $schoolId);

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $teachers = $query->orderBy('first_name')->get();
        $totalTeachers = User::teachers()->where('school_id', $schoolId)->count();
        $activeTeachers = User::teachers()->where('school_id', $schoolId)->where('is_active', true)->count();

        return view('reports.school-admin.teachers', compact(
            'teachers',
            'totalTeachers',
            'activeTeachers',
            'status'
        ));
    }

    /**
     * Staff Report - School Admin
     */
    public function staff(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $status = $request->get('status', 'all');

        $query = User::query()
            ->staff()
            ->where('school_id', $schoolId);

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $staff = $query->orderBy('first_name')->get();
        $totalStaff = User::staff()->where('school_id', $schoolId)->count();
        $activeStaff = User::staff()->where('school_id', $schoolId)->where('is_active', true)->count();

        return view('reports.school-admin.staff', compact(
            'staff',
            'totalStaff',
            'activeStaff',
            'status'
        ));
    }

    /**
     * Attendance Report - School Admin
     */
    public function attendance(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $role = $request->get('role', 'student');
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = Attendance::query()
            ->where('school_id', $schoolId)
            ->whereBetween('date', [$startDate, $endDate])
            ->with(['user.academicClass', 'user.section']);

        if ($role !== 'all') {
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        if ($classId) {
            $query->whereHas('user', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        if ($sectionId) {
            $query->whereHas('user', function ($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            });
        }

        $attendances = $query->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
        ];

        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('reports.school-admin.attendance', compact(
            'attendances',
            'stats',
            'classes',
            'sections',
            'role',
            'startDate',
            'endDate',
            'classId',
            'sectionId'
        ));
    }

    /**
     * Fee Collection Report - School Admin
     */
    public function fees(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $status = $request->get('status', 'all');
        $classId = $request->get('class_id');

        $query = StudentFeeTransaction::query()
            ->where('school_id', $schoolId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['student.academicClass', 'feeStructure', 'academicSession']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($classId) {
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        $stats = [
            'total_amount' => $transactions->where('status', 'completed')->sum('amount'),
            'total_transactions' => $transactions->count(),
            'completed' => $transactions->where('status', 'completed')->count(),
            'pending' => $transactions->where('status', 'pending')->count(),
        ];

        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('reports.school-admin.fees', compact(
            'transactions',
            'stats',
            'classes',
            'startDate',
            'endDate',
            'status',
            'classId'
        ));
    }

    /**
     * Exam & Results Report - School Admin
     */
    public function examResults(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $examId = $request->get('exam_id');
        $classId = $request->get('class_id');
        $academicSessionId = $request->get('academic_session_id');

        $query = Result::query()
            ->where('school_id', $schoolId)
            ->with(['student.academicClass', 'exam', 'subject', 'academicSession']);

        if ($examId) {
            $query->where('exam_id', $examId);
        }

        if ($classId) {
            $query->where('academic_class_id', $classId);
        }

        if ($academicSessionId) {
            $query->where('academic_session_id', $academicSessionId);
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('reports.school-admin.exam-results', compact(
            'results',
            'exams',
            'classes',
            'academicSessions',
            'examId',
            'classId',
            'academicSessionId'
        ));
    }

    /**
     * Library Report - School Admin
     */
    public function library(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $status = $request->get('status', 'all');

        $query = BookIssue::query()
            ->where('school_id', $schoolId)
            ->with(['user', 'library']);

        if ($status === 'issued') {
            $query->where('status', 'issued');
        } elseif ($status === 'returned') {
            $query->where('status', 'returned');
        } elseif ($status === 'overdue') {
            $query->where('status', 'issued')
                ->where('due_date', '<', date('Y-m-d'));
        }

        $bookIssues = $query->orderBy('issue_date', 'desc')->get();

        $stats = [
            'total_issued' => BookIssue::where('school_id', $schoolId)->where('status', 'issued')->count(),
            'total_returned' => BookIssue::where('school_id', $schoolId)->where('status', 'returned')->count(),
            'overdue' => BookIssue::where('school_id', $schoolId)
                ->where('status', 'issued')
                ->where('due_date', '<', date('Y-m-d'))
                ->count(),
        ];

        return view('reports.school-admin.library', compact(
            'bookIssues',
            'stats',
            'status'
        ));
    }

    // ==================== TEACHER REPORTS ====================

    /**
     * Class Students Report - Teacher
     */
    public function classStudents(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $teacherId = auth()->user()->id;
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = User::query()
            ->students()
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->with(['academicClass', 'section']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        $students = $query->orderBy('first_name')->get();

        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('reports.teacher.class-students', compact(
            'students',
            'classes',
            'sections',
            'classId',
            'sectionId'
        ));
    }

    /**
     * Attendance Report - Teacher
     */
    public function teacherAttendance(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = Attendance::query()
            ->where('school_id', $schoolId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereHas('user', function ($q) {
                $q->students();
            })
            ->with(['user.academicClass', 'user.section']);

        if ($classId) {
            $query->whereHas('user', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        if ($sectionId) {
            $query->whereHas('user', function ($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            });
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
        ];

        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $sections = Section::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('reports.teacher.attendance', compact(
            'attendances',
            'stats',
            'classes',
            'sections',
            'startDate',
            'endDate',
            'classId',
            'sectionId'
        ));
    }

    /**
     * Student Results Report - Teacher
     */
    public function teacherResults(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $examId = $request->get('exam_id');
        $classId = $request->get('class_id');
        $academicSessionId = $request->get('academic_session_id');

        $query = Result::query()
            ->where('school_id', $schoolId)
            ->with(['student.academicClass', 'exam', 'subject', 'academicSession']);

        if ($examId) {
            $query->where('exam_id', $examId);
        }

        if ($classId) {
            $query->where('academic_class_id', $classId);
        }

        if ($academicSessionId) {
            $query->where('academic_session_id', $academicSessionId);
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        $exams = Exam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');
        $classes = AcademicClass::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('reports.teacher.results', compact(
            'results',
            'exams',
            'classes',
            'academicSessions',
            'examId',
            'classId',
            'academicSessionId'
        ));
    }
}