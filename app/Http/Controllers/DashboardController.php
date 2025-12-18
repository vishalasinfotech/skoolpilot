<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Library;
use App\Models\Result;
use App\Models\School;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\Transportation;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $role = $user->role;
        $schoolId = $user->school_id;
        $isSchoolAdmin = in_array($role, ['school_admin', 'school-admin'], true);

        $data = [];

        // Super Admin Dashboard Data
        if ($role === 'super_admin') {
            $data = [
                'total_schools' => School::count(),
                'active_schools' => School::where('status', true)->count(),
                'total_subscriptions' => School::whereNotNull('subscription_plan_id')->count(),
                'recent_schools' => School::latest()->take(5)->get(),
            ];
        }

        // School Admin Dashboard Data
        if ($isSchoolAdmin && $schoolId) {
            $today = date('Y-m-d');
            $latestSubscriptionTransaction = Transaction::query()
                ->with('subscriptionPlan')
                ->where('school_id', $schoolId)
                ->where('status', 'completed')
                ->orderByDesc('paid_at')
                ->orderByDesc('id')
                ->first();

            $subscriptionExpiresAt = $latestSubscriptionTransaction?->expires_at;
            $subscriptionPlanName = $latestSubscriptionTransaction?->subscriptionPlan?->name;

            if (! $subscriptionPlanName) {
                $school = School::query()
                    ->with('subscriptionPlan')
                    ->find($schoolId);

                $subscriptionPlanName = $school?->subscriptionPlan?->name;
            }

            $subscriptionStatus = 'none';
            if ($latestSubscriptionTransaction) {
                $subscriptionStatus = ($subscriptionExpiresAt !== null && $subscriptionExpiresAt->isPast())
                    ? 'expired'
                    : 'active';
            }

            $data = [
                'total_students' => User::where('school_id', $schoolId)->students()->where('is_active', true)->count(),
                'total_teachers' => User::where('school_id', $schoolId)->teachers()->where('is_active', true)->count(),
                'total_staff' => User::where('school_id', $schoolId)->staff()->where('is_active', true)->count(),
                'total_classes' => AcademicClass::where('school_id', $schoolId)->where('is_active', true)->count(),
                'total_subjects' => Subject::where('school_id', $schoolId)->where('is_active', true)->count(),
                'today_attendance' => Attendance::where('school_id', $schoolId)->where('date', $today)->count(),
                'upcoming_exams' => Exam::where('school_id', $schoolId)
                    ->where('is_active', true)
                    ->where('start_date', '>=', $today)
                    ->orderBy('start_date')
                    ->take(5)
                    ->get(),
                'recent_results' => Result::where('school_id', $schoolId)
                    ->with(['student', 'exam', 'subject'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'total_books' => Library::where('school_id', $schoolId)->count(),
                'available_books' => Library::where('school_id', $schoolId)->sum('available_copies'),
                'total_vehicles' => Transportation::where('school_id', $schoolId)->where('is_active', true)->count(),
                'subscription' => [
                    'plan_name' => $subscriptionPlanName,
                    'expires_at' => $subscriptionExpiresAt,
                    'status' => $subscriptionStatus,
                    'remaining_days' => $subscriptionExpiresAt ? now()->diffInDays($subscriptionExpiresAt, false) : null,
                ],
            ];
        }

        // Teacher Dashboard Data
        if ($role === 'teacher' && $schoolId) {
            $today = date('Y-m-d');
            $data = [
                'my_students' => User::where('school_id', $schoolId)
                    ->students()
                    ->where('is_active', true)
                    ->count(),
                'today_attendance' => Attendance::where('school_id', $schoolId)
                    ->where('date', $today)
                    ->whereHas('user', function ($q) {
                        $q->students();
                    })
                    ->count(),
                'upcoming_exams' => ExamSchedule::where('school_id', $schoolId)
                    ->with(['exam', 'subject', 'academicClass'])
                    ->where('exam_date', '>=', $today)
                    ->orderBy('exam_date')
                    ->take(5)
                    ->get(),
                'recent_attendance' => Attendance::where('school_id', $schoolId)
                    ->where('date', $today)
                    ->with(['user'])
                    ->whereHas('user', function ($q) {
                        $q->students();
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get(),
            ];
        }

        // Student Dashboard Data
        if ($role === 'student' && $schoolId) {
            $today = date('Y-m-d');
            $data = [
                'my_attendance' => Attendance::where('user_id', $user->id)
                    ->where('date', $today)
                    ->first(),
                'attendance_stats' => [
                    'present' => Attendance::where('user_id', $user->id)
                        ->where('status', 'present')
                        ->whereMonth('date', date('m'))
                        ->whereYear('date', date('Y'))
                        ->count(),
                    'absent' => Attendance::where('user_id', $user->id)
                        ->where('status', 'absent')
                        ->whereMonth('date', date('m'))
                        ->whereYear('date', date('Y'))
                        ->count(),
                ],
                'upcoming_exams' => ExamSchedule::where('school_id', $schoolId)
                    ->where('academic_class_id', $user->class_id)
                    ->with(['exam', 'subject'])
                    ->where('exam_date', '>=', $today)
                    ->orderBy('exam_date')
                    ->take(5)
                    ->get(),
                'my_results' => Result::where('student_id', $user->id)
                    ->with(['exam', 'subject'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        }

        // Staff Dashboard Data
        if ($role === 'staff' && $schoolId) {
            $today = date('Y-m-d');
            $data = [
                'my_attendance' => Attendance::where('user_id', $user->id)
                    ->where('date', $today)
                    ->first(),
                'attendance_stats' => [
                    'present' => Attendance::where('user_id', $user->id)
                        ->where('status', 'present')
                        ->whereMonth('date', date('m'))
                        ->whereYear('date', date('Y'))
                        ->count(),
                    'absent' => Attendance::where('user_id', $user->id)
                        ->where('status', 'absent')
                        ->whereMonth('date', date('m'))
                        ->whereYear('date', date('Y'))
                        ->count(),
                ],
                'total_books' => Library::where('school_id', $schoolId)->count(),
                'available_books' => Library::where('school_id', $schoolId)->sum('available_copies'),
                'total_vehicles' => Transportation::where('school_id', $schoolId)->where('is_active', true)->count(),
            ];
        }

        // Parent Dashboard Data (if exists)
        if ($role === 'parent' && $schoolId) {
            $data = [
                'children' => User::where('school_id', $schoolId)
                    ->students()
                    ->where(function ($query) use ($user) {
                        $query->where('parent_email', $user->email)
                            ->orWhere('parent_phone', $user->phone);
                    })
                    ->get(),
            ];
        }

        return view('dashboard.index', compact('data', 'role', 'user'));
    }
}
