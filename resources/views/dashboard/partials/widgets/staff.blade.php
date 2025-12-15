{{-- Staff Widgets --}}
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
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="ri-book-read-line text-info"></i>
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
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="ri-bus-line text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

