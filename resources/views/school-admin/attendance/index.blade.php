@extends('layouts.master')
@section('title', 'Attendance Management')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Attendance Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                <li class="breadcrumb-item active">Mark Attendance</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mark Attendance</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('school-admin.attendance.index') }}" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Role</label>
                                        <select name="role" class="form-select" onchange="this.form.submit()">
                                            <option value="student" {{ $role === 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="teacher" {{ $role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                            <option value="staff" {{ $role === 'staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ $date }}" max="{{ date('Y-m-d') }}" onchange="this.form.submit()">
                                    </div>
                                    @if($role === 'student')
                                    <div class="col-md-3">
                                        <label class="form-label">Class</label>
                                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $id => $name)
                                                <option value="{{ $id }}" {{ $classId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Section</label>
                                        <select name="section_id" class="form-select" onchange="this.form.submit()">
                                            <option value="">All Sections</option>
                                            @foreach($sections as $id => $name)
                                                <option value="{{ $id }}" {{ $sectionId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </form>

                            @if($users->count() > 0)
                            <form method="POST" action="{{ route('school-admin.attendance.store') }}" id="attendanceForm">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">
                                <input type="hidden" name="role" value="{{ $role }}">
                                <input type="hidden" name="class_id" value="{{ $classId }}">
                                <input type="hidden" name="section_id" value="{{ $sectionId }}">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Name</th>
                                                @if($role === 'student')
                                                <th width="10%">Admission No.</th>
                                                <th width="10%">Class</th>
                                                <th width="10%">Section</th>
                                                @else
                                                <th width="15%">Employee ID</th>
                                                <th width="15%">Designation</th>
                                                @endif
                                                <th width="15%">Status</th>
                                                @if($role !== 'student')
                                                <th width="10%">Check In</th>
                                                <th width="10%">Check Out</th>
                                                @endif
                                                <th width="15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $index => $user)
                                                @php
                                                    $existingAttendance = $attendanceRecords->get($user->id);
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $user->full_name }}</strong>
                                                        @if($user->email)
                                                            <br><small class="text-muted">{{ $user->email }}</small>
                                                        @endif
                                                    </td>
                                                    @if($role === 'student')
                                                    <td>{{ $user->admission_number }}</td>
                                                    <td>{{ $user->academicClass->name ?? '-' }}</td>
                                                    <td>{{ $user->section->name ?? '-' }}</td>
                                                    @else
                                                    <td>{{ $user->employee_id }}</td>
                                                    <td>{{ $user->designation ?? '-' }}</td>
                                                    @endif
                                                    <td>
                                                        <select name="attendance[{{ $index }}][status]" class="form-select form-select-sm status-select" required>
                                                            <option value="present" {{ ($existingAttendance && $existingAttendance->status === 'present') ? 'selected' : '' }}>Present</option>
                                                            <option value="absent" {{ ($existingAttendance && $existingAttendance->status === 'absent') ? 'selected' : '' }}>Absent</option>
                                                            <option value="late" {{ ($existingAttendance && $existingAttendance->status === 'late') ? 'selected' : '' }}>Late</option>
                                                            <option value="half_day" {{ ($existingAttendance && $existingAttendance->status === 'half_day') ? 'selected' : '' }}>Half Day</option>
                                                            <option value="leave" {{ ($existingAttendance && $existingAttendance->status === 'leave') ? 'selected' : '' }}>Leave</option>
                                                            <option value="holiday" {{ ($existingAttendance && $existingAttendance->status === 'holiday') ? 'selected' : '' }}>Holiday</option>
                                                        </select>
                                                        <input type="hidden" name="attendance[{{ $index }}][user_id]" value="{{ $user->id }}">
                                                    </td>
                                                    @if($role !== 'student')
                                                    <td>
                                                        <input type="time" name="attendance[{{ $index }}][check_in_time]" 
                                                               class="form-control form-control-sm" 
                                                               value="{{ $existingAttendance ? ($existingAttendance->check_in_time ? date('H:i', strtotime($existingAttendance->check_in_time)) : '') : '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="attendance[{{ $index }}][check_out_time]" 
                                                               class="form-control form-control-sm" 
                                                               value="{{ $existingAttendance ? ($existingAttendance->check_out_time ? date('H:i', strtotime($existingAttendance->check_out_time)) : '') : '' }}">
                                                    </td>
                                                    @endif
                                                    <td>
                                                        <input type="text" name="attendance[{{ $index }}][remarks]" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Remarks" 
                                                               value="{{ $existingAttendance ? $existingAttendance->remarks : '' }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-middle me-1"></i> Save Attendance
                                    </button>
                                </div>
                            </form>
                            @else
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                No {{ $role }}s found for the selected filters.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Quick select all present/absent
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelects = document.querySelectorAll('.status-select');
            
            // Add quick action buttons
            const quickActions = document.createElement('div');
            quickActions.className = 'mb-3';
            quickActions.innerHTML = `
                <button type="button" class="btn btn-sm btn-success" onclick="setAllStatus('present')">
                    <i class="ri-check-line"></i> All Present
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="setAllStatus('absent')">
                    <i class="ri-close-line"></i> All Absent
                </button>
            `;
            document.querySelector('#attendanceForm').insertBefore(quickActions, document.querySelector('#attendanceForm .table-responsive'));
            
            window.setAllStatus = function(status) {
                statusSelects.forEach(select => {
                    select.value = status;
                });
            };
        });
    </script>
@endsection

