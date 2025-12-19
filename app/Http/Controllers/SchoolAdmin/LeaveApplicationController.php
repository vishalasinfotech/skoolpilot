<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\LeaveApplication\StoreLeaveApplicationRequest;
use App\Models\LeaveApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class LeaveApplicationController extends Controller
{
    public function index(): View
    {
        return view('school-admin.leave-application.index');
    }

    public function teacherIndex(): View
    {
        return view('school-admin.leave-application.teacher-index');
    }

    public function create(): View
    {
        return view('school-admin.leave-application.create');
    }

    public function store(StoreLeaveApplicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        LeaveApplication::create([
            'teacher_id' => auth()->id(),
            'school_id' => auth()->user()->school_id,
            'leave_type' => $validated['leave_type'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $totalDays,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('teacher.leave-application.index')
            ->with('success', 'Leave application submitted successfully!');
    }

    public function show(LeaveApplication $leaveApplication): View
    {
        return view('school-admin.leave-application.show', [
            'leaveApplication' => $leaveApplication,
        ]);
    }

    public function destroy(LeaveApplication $leaveApplication): RedirectResponse
    {
        $leaveApplication->delete();

        return redirect()
            ->back()
            ->with('success', 'Leave application deleted successfully!');
    }
}
