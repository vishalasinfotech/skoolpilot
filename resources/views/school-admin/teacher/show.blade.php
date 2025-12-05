@extends('layouts.master')
@section('title', 'Teacher Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Teacher Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.teacher.index') }}">Teachers</a></li>
                                <li class="breadcrumb-item active">View Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Teacher Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.teacher.edit', $teacher->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-fill"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.teacher.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="col-md-3 text-center mb-4">
                                    @php
                                        $defaultImage = asset('admin_theme/assets/images/default/default.png');
                                        $imagePath = $teacher->profile_image ? public_path($teacher->profile_image) : null;
                                    @endphp
                                    @if($teacher->profile_image && $imagePath && file_exists($imagePath))
                                        <img src="{{ asset($teacher->profile_image) }}" alt="{{ $teacher->full_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ $defaultImage }}" alt="{{ $teacher->full_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                                    <div>
                                        @if($teacher->is_active)
                                            <span class="badge bg-success-subtle text-success fs-6">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fs-6">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Teacher Details -->
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Full Name</label>
                                            <p class="fs-5 fw-medium">{{ $teacher->full_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Employee ID</label>
                                            <p><span class="badge bg-primary fs-6">{{ $teacher->employee_id }}</span></p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">School</label>
                                            <p class="fs-6">{{ $teacher->school->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Email</label>
                                            <p class="fs-6">{{ $teacher->email }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Phone</label>
                                            <p>{{ $teacher->phone ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Gender</label>
                                            <p>{{ $teacher->gender ? ucfirst($teacher->gender) : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Date of Birth</label>
                                            <p>{{ $teacher->date_of_birth ? $teacher->date_of_birth->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Qualification</label>
                                            <p>{{ $teacher->qualification ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Specialization</label>
                                            <p>{{ $teacher->specialization ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Joining Date</label>
                                            <p>{{ $teacher->joining_date ? $teacher->joining_date->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Salary</label>
                                            @if($teacher->salary)
                                                <p class="fs-6 fw-medium text-success">${{ number_format($teacher->salary, 2) }}</p>
                                            @else
                                                <p>N/A</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($teacher->address)
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label text-muted fw-semibold">Address</label>
                                            <p class="text-muted">{{ $teacher->address }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Created At</label>
                                            <p>{{ $teacher->created_at->format('F d, Y h:i A') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Last Updated</label>
                                            <p>{{ $teacher->updated_at->format('F d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

