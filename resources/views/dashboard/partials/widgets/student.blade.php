{{-- Student Widgets --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Today's Status</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        @if(isset($data['my_attendance']) && $data['my_attendance'])
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="badge bg-{{ $data['my_attendance']->status === 'present' ? 'success' : ($data['my_attendance']->status === 'absent' ? 'danger' : 'warning') }}-subtle text-{{ $data['my_attendance']->status === 'present' ? 'success' : ($data['my_attendance']->status === 'absent' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($data['my_attendance']->status) }}
                                </span>
                            </h4>
                        @else
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="badge bg-secondary-subtle text-secondary">Not Marked</span>
                            </h4>
                        @endif
                        <a href="{{ route('school-admin.attendance.index') }}" class="text-decoration-underline">View attendance</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="ri-calendar-check-line text-primary"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Present Days</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['attendance_stats']['present'] ?? 0 }}">{{ $data['attendance_stats']['present'] ?? 0 }}</span>
                        </h4>
                        <small class="text-muted">This month</small>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Absent Days</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['attendance_stats']['absent'] ?? 0 }}">{{ $data['attendance_stats']['absent'] ?? 0 }}</span>
                        </h4>
                        <small class="text-muted">This month</small>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Upcoming Exams</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['upcoming_exams']->count() ?? 0 }}">{{ $data['upcoming_exams']->count() ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.exam-schedule.index') }}" class="text-decoration-underline">View schedules</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="ri-file-list-3-line text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Upcoming Exams --}}
@if(isset($data['upcoming_exams']) && $data['upcoming_exams']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Upcoming Exams</h5>
                <a href="{{ route('school-admin.exam-schedule.index') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['upcoming_exams'] as $schedule)
                                <tr>
                                    <td><span class="fw-medium">{{ $schedule->exam->name ?? 'N/A' }}</span></td>
                                    <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->exam_date->format('d M Y') }}</td>
                                    <td>
                                        @if($schedule->start_time && $schedule->end_time)
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $schedule->room_number ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- My Results --}}
@if(isset($data['my_results']) && $data['my_results']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Recent Results</h5>
                <a href="{{ route('school-admin.result.index') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['my_results'] as $result)
                                <tr>
                                    <td><span class="fw-medium">{{ $result->exam->name ?? 'N/A' }}</span></td>
                                    <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $result->obtained_marks }}/{{ $result->total_marks }}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">{{ $result->grade ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($result->status === 'pass')
                                            <span class="badge bg-success-subtle text-success">Pass</span>
                                        @elseif($result->status === 'fail')
                                            <span class="badge bg-danger-subtle text-danger">Fail</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Absent</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

