@extends('layouts.master')
@section('title', 'Attendance Report')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Attendance Report</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.attendance.index', ['role' => $role]) }}">Attendance</a></li>
                                <li class="breadcrumb-item active">Report</li>
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
                            <h5 class="card-title mb-0">Attendance Report for {{ $user->full_name }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('school-admin.attendance.show') }}" class="mb-4">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="role" value="{{ $role }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="ri-search-line"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="text-white-50 mb-2">Present</h6>
                                            <h3 class="mb-0">{{ $stats['present'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body">
                                            <h6 class="text-white-50 mb-2">Absent</h6>
                                            <h3 class="mb-0">{{ $stats['absent'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h6 class="text-white-50 mb-2">Late</h6>
                                            <h3 class="mb-0">{{ $stats['late'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="text-white-50 mb-2">Half Day</h6>
                                            <h3 class="mb-0">{{ $stats['half_day'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            @if($role !== 'student')
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            @endif
                                            <th>Remarks</th>
                                            <th>Marked By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                                <td>
                                                    @php
                                                        $badgeColors = [
                                                            'present' => 'success',
                                                            'absent' => 'danger',
                                                            'late' => 'warning',
                                                            'half_day' => 'info',
                                                            'leave' => 'primary',
                                                            'holiday' => 'secondary'
                                                        ];
                                                        $color = $badgeColors[$attendance->status] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
                                                </td>
                                                @if($role !== 'student')
                                                <td>{{ $attendance->check_in_time ? date('h:i A', strtotime($attendance->check_in_time)) : '-' }}</td>
                                                <td>{{ $attendance->check_out_time ? date('h:i A', strtotime($attendance->check_out_time)) : '-' }}</td>
                                                @endif
                                                <td>{{ $attendance->remarks ?? '-' }}</td>
                                                <td>{{ $attendance->markedBy->full_name ?? '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $attendance->id }}">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <form action="{{ route('school-admin.attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $attendance->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('school-admin.attendance.update', $attendance) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Attendance</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Date</label>
                                                                    <input type="date" name="date" class="form-control" value="{{ $attendance->date->format('Y-m-d') }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Status</label>
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                                                                        <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                                                        <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                                                                        <option value="half_day" {{ $attendance->status === 'half_day' ? 'selected' : '' }}>Half Day</option>
                                                                        <option value="leave" {{ $attendance->status === 'leave' ? 'selected' : '' }}>Leave</option>
                                                                        <option value="holiday" {{ $attendance->status === 'holiday' ? 'selected' : '' }}>Holiday</option>
                                                                    </select>
                                                                </div>
                                                                @if($role !== 'student')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Check In Time</label>
                                                                    <input type="time" name="check_in_time" class="form-control" value="{{ $attendance->check_in_time ? date('H:i', strtotime($attendance->check_in_time)) : '' }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Check Out Time</label>
                                                                    <input type="time" name="check_out_time" class="form-control" value="{{ $attendance->check_out_time ? date('H:i', strtotime($attendance->check_out_time)) : '' }}">
                                                                </div>
                                                                @endif
                                                                <div class="mb-3">
                                                                    <label class="form-label">Remarks</label>
                                                                    <textarea name="remarks" class="form-control" rows="3">{{ $attendance->remarks }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $role === 'student' ? '6' : '8' }}" class="text-center">No attendance records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $attendances->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

