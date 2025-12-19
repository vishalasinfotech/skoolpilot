@extends('layouts.master')
@section('title', 'Student Attendance')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Student Attendance</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                <li class="breadcrumb-item active">Student Attendance</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Mark Student Attendance</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.attendance.index', ['role' => 'teacher']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-user-3-line align-middle me-1"></i> Teacher Attendance
                                </a>
                                <a href="{{ route('school-admin.attendance.index', ['role' => 'staff']) }}" class="btn btn-sm btn-outline-info">
                                    <i class="ri-team-line align-middle me-1"></i> Staff Attendance
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('school-admin.attendance.index') }}" class="mb-4">
                                <input type="hidden" name="role" value="student">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ $date }}" max="{{ date('Y-m-d') }}" onchange="this.form.submit()">
                                    </div>
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
                                    <div class="col-md-3">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="ri-search-line align-middle me-1"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>

                            @if($users->count() > 0)
                            <form method="POST" action="{{ route('school-admin.attendance.store') }}" id="attendanceForm">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">
                                <input type="hidden" name="role" value="student">
                                <input type="hidden" name="class_id" value="{{ $classId }}">
                                <input type="hidden" name="section_id" value="{{ $sectionId }}">

                                <div class="mb-3">
                                    <button type="button" class="btn btn-sm btn-success me-2" onclick="setAllStatus('present')">
                                        <i class="ri-check-line"></i> Mark All Present
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="setAllStatus('absent')">
                                        <i class="ri-close-line"></i> Mark All Absent
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Name</th>
                                                <th width="12%">Admission No.</th>
                                                <th width="12%">Class</th>
                                                <th width="12%">Section</th>
                                                <th width="15%">Status</th>
                                                <th width="20%">Remarks</th>
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
                                                    <td>{{ $user->admission_number ?? '-' }}</td>
                                                    <td>{{ $user->academicClass->name ?? '-' }}</td>
                                                    <td>{{ $user->section->name ?? '-' }}</td>
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
                                                    <td>
                                                        <input type="text" name="attendance[{{ $index }}][remarks]"
                                                               class="form-control form-control-sm"
                                                               placeholder="Remarks (optional)"
                                                               value="{{ $existingAttendance ? $existingAttendance->remarks : '' }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-middle me-1"></i> Save Student Attendance
                                    </button>
                                </div>
                            </form>
                            @else
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                No students found for the selected filters.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAllStatus(status) {
            const statusSelects = document.querySelectorAll('.status-select');
            statusSelects.forEach(select => {
                select.value = status;
            });
        }
    </script>
@endsection

