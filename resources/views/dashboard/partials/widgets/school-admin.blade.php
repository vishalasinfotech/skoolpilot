{{-- School Admin Widgets --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Students</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_students'] ?? 0 }}">{{ $data['total_students'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.student.index') }}" class="text-decoration-underline">View all students</a>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Teachers</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_teachers'] ?? 0 }}">{{ $data['total_teachers'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.teacher.index') }}" class="text-decoration-underline">View all teachers</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-user-3-line text-success"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Classes</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_classes'] ?? 0 }}">{{ $data['total_classes'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.academic-class.index') }}" class="text-decoration-underline">View all classes</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="ri-book-open-line text-info"></i>
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
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="ri-calendar-check-line text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Staff</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_staff'] ?? 0 }}">{{ $data['total_staff'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.staff.index') }}" class="text-decoration-underline">View all staff</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                            <i class="ri-group-line text-danger"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Subjects</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_subjects'] ?? 0 }}">{{ $data['total_subjects'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.subject.index') }}" class="text-decoration-underline">View all subjects</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-purple-subtle rounded fs-3">
                            <i class="ri-book-2-line text-purple"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Library Books</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_books'] ?? 0 }}">{{ $data['total_books'] ?? 0 }}</span>
                        </h4>
                        <small class="text-muted">Available: {{ $data['available_books'] ?? 0 }}</small>
                        <br><a href="{{ route('school-admin.library.index') }}" class="text-decoration-underline">View library</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary-subtle rounded fs-3">
                            <i class="ri-book-read-line text-secondary"></i>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Vehicles</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_vehicles'] ?? 0 }}">{{ $data['total_vehicles'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('school-admin.transportation.index') }}" class="text-decoration-underline">View transportation</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-dark-subtle rounded fs-3">
                            <i class="ri-bus-line text-dark"></i>
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
                <h5 class="card-title mb-0">Upcoming Exams</h5>
                <a href="{{ route('school-admin.exam.index') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Exam Name</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['upcoming_exams'] as $exam)
                                <tr>
                                    <td><span class="fw-medium">{{ $exam->name }}</span></td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">{{ ucfirst(str_replace('_', ' ', $exam->exam_type)) }}</span>
                                    </td>
                                    <td>{{ $exam->start_date->format('d M Y') }}</td>
                                    <td>
                                        @if($exam->is_active)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
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

{{-- Recent Results --}}
@if(isset($data['recent_results']) && $data['recent_results']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Results</h5>
                <a href="{{ route('school-admin.result.index') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_results'] as $result)
                                <tr>
                                    <td><span class="fw-medium">{{ $result->student->name ?? 'N/A' }}</span></td>
                                    <td>{{ $result->exam->name ?? 'N/A' }}</td>
                                    <td>{{ $result->subject->name ?? 'N/A' }}</td>
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

