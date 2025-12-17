{{-- Teacher Widgets --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">My Students</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['my_students'] ?? 0 }}">{{ $data['my_students'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.student.index') }}" class="text-decoration-underline">View students</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="ri-user-line text-primary"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Today's Attendance</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['today_attendance'] ?? 0 }}">{{ $data['today_attendance'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.attendance.index') }}" class="text-decoration-underline">Mark attendance</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-calendar-check-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Upcoming Exams Schedule --}}
@if(isset($data['upcoming_exams']) && $data['upcoming_exams']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Upcoming Exam Schedules</h5>
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
                                <th>Class</th>
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
                                    <td>{{ $schedule->academicClass->name ?? 'N/A' }}</td>
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

