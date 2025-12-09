<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Attendance\UpdateAttendanceRequest;
use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display attendance index page.
     */
    public function index(Request $request): View
    {
        $role = $request->get('role', 'student'); // student, teacher, staff
        $date = $request->get('date', date('Y-m-d'));
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = User::query()
            ->where('school_id', auth()->user()->school_id)
            ->where('role', $role)
            ->where('is_active', true);

        // For students, filter by class and section
        if ($role === 'student') {
            if ($classId) {
                $query->where('class_id', $classId);
            }
            if ($sectionId) {
                $query->where('section_id', $sectionId);
            }
        }

        $users = $query->orderBy('first_name')->get();

        // Get existing attendance for the date
        $attendanceRecords = Attendance::where('date', $date)
            ->whereIn('user_id', $users->pluck('id'))
            ->get()
            ->keyBy('user_id');

        $classes = AcademicClass::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $sections = Section::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.attendance.index', compact(
            'users',
            'attendanceRecords',
            'role',
            'date',
            'classId',
            'sectionId',
            'classes',
            'sections'
        ));
    }

    /**
     * Store attendance for multiple users.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'role' => ['required', 'in:student,teacher,staff'],
            'attendance' => ['required', 'array'],
            'attendance.*.user_id' => ['required', 'exists:users,id'],
            'attendance.*.status' => ['required', 'in:present,absent,late,half_day,leave,holiday'],
            'attendance.*.check_in_time' => ['nullable', 'date_format:H:i'],
            'attendance.*.check_out_time' => ['nullable', 'date_format:H:i'],
            'attendance.*.remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $date = $request->date;
        $schoolId = auth()->user()->school_id;
        $markedBy = auth()->id();

        foreach ($request->attendance as $attendanceData) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $attendanceData['user_id'],
                    'date' => $date,
                ],
                [
                    'school_id' => $schoolId,
                    'status' => $attendanceData['status'],
                    'check_in_time' => $attendanceData['check_in_time'] ?? null,
                    'check_out_time' => $attendanceData['check_out_time'] ?? null,
                    'remarks' => $attendanceData['remarks'] ?? null,
                    'marked_by' => $markedBy,
                ]
            );
        }

        $roleName = ucfirst($request->role);
        $redirectRoute = $request->role === 'student' ? 'school-admin.attendance.index' : 'school-admin.attendance.index';

        return redirect()->route($redirectRoute, [
            'role' => $request->role,
            'date' => $date,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
        ])->with('success', "Attendance marked successfully for {$roleName}s.");
    }

    /**
     * Show attendance report.
     */
    public function show(Request $request): View
    {
        $role = $request->get('role', 'student');
        $userId = $request->get('user_id');
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));

        $user = User::where('id', $userId)
            ->where('school_id', auth()->user()->school_id)
            ->where('role', $role)
            ->firstOrFail();

        $attendances = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->paginate(30);

        $stats = [
            'total_days' => $attendances->total(),
            'present' => Attendance::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'present')
                ->count(),
            'absent' => Attendance::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'absent')
                ->count(),
            'late' => Attendance::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'late')
                ->count(),
            'half_day' => Attendance::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'half_day')
                ->count(),
        ];

        return view('school-admin.attendance.show', compact('user', 'attendances', 'stats', 'role', 'startDate', 'endDate'));
    }

    /**
     * Update a single attendance record.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance): RedirectResponse
    {
        $data = $request->validated();
        $data['marked_by'] = auth()->id();

        $attendance->update($data);

        return redirect()->back()->with('success', 'Attendance updated successfully.');
    }

    /**
     * Delete an attendance record.
     */
    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully.');
    }
}
