@extends('layouts.master')
@section('title', __('common.student_reports'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.student_reports') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('common.dashboards') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('parent.my-children') }}">{{ __('common.my_children') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.student_reports') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <!-- Filter Form -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('parent.student-reports') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Select Child</label>
                                    <select name="student_id" class="form-select">
                                        <option value="">Select a child</option>
                                        @foreach($children as $child)
                                            <option value="{{ $child->id }}" {{ $studentId == $child->id ? 'selected' : '' }}>
                                                {{ $child->name }} ({{ $child->admission_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Academic Session</label>
                                    <select name="academic_session_id" class="form-select">
                                        <option value="">All Sessions</option>
                                        @foreach($academicSessions as $id => $name)
                                            <option value="{{ $id }}" {{ $academicSessionId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('parent.student-reports') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($studentId)
                <!-- Attendance Statistics -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Days</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $attendanceStats['total'] }}">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="ri-calendar-line text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Present</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $attendanceStats['present'] }}">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="ri-checkbox-circle-line text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Absent</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $attendanceStats['absent'] }}">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                            <i class="ri-close-circle-line text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Late</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $attendanceStats['late'] }}">0</span></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="ri-time-line text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('common.results') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('common.exams') }}</th>
                                                <th>{{ __('common.subjects') }}</th>
                                                <th>{{ __('common.classes') }}</th>
                                                <th>Obtained Marks</th>
                                                <th>Total Marks</th>
                                                <th>Percentage</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($results as $result)
                                                <tr>
                                                    <td><span class="fw-medium">{{ $result->exam->name ?? 'N/A' }}</span></td>
                                                    <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                                    <td>{{ $result->academicClass->name ?? 'N/A' }}</td>
                                                    <td>{{ $result->obtained_marks }}</td>
                                                    <td>{{ $result->total_marks }}</td>
                                                    <td>{{ number_format($result->percentage, 2) }}%</td>
                                                    <td>{{ $result->grade }}</td>
                                                    <td>
                                                        @if($result->status === 'pass')
                                                            <span class="badge bg-success">Pass</span>
                                                        @else
                                                            <span class="badge bg-danger">Fail</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No results found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Attendance</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($attendances as $attendance)
                                                <tr>
                                                    <td>{{ $attendance->date->format('d M Y') }}</td>
                                                    <td>
                                                        @if($attendance->status === 'present')
                                                            <span class="badge bg-success">Present</span>
                                                        @elseif($attendance->status === 'absent')
                                                            <span class="badge bg-danger">Absent</span>
                                                        @elseif($attendance->status === 'late')
                                                            <span class="badge bg-warning">Late</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($attendance->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $attendance->remarks ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">No attendance records found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                           trigger="loop"
                                           colors="primary:#121331,secondary:#08a88a"
                                           style="width:120px;height:120px"></lord-icon>
                                <h4 class="mt-4">Select a Child</h4>
                                <p class="text-muted">Please select a child from the dropdown above to view their reports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

