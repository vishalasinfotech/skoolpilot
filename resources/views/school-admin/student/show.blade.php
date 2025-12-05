@extends('layouts.master')
@section('title', 'Student Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Student Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('school-admin.student.index') }}">Students</a>
                                </li>
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
                            <h5 class="card-title mb-0">Student Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.student.edit', $student->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-fill"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary btn-sm">
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
                                        $imagePath = $student->profile_image ? public_path($student->profile_image) : null;
                                    @endphp
                                    @if($student->profile_image && $imagePath && file_exists($imagePath))
                                        <img src="{{ asset($student->profile_image) }}" alt="{{ $student->first_name }} {{ $student->last_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ $defaultImage }}" alt="{{ $student->first_name }} {{ $student->last_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                                    <div>
                                        @if($student->is_active)
                                            <span class="badge bg-success-subtle text-success fs-6">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fs-6">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Student Details -->
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Full Name</label>
                                            <p class="fs-5 fw-medium">{{ $student->first_name ?? 'N/A' }} {{ $student->last_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Admission Number</label>
                                            <p>
                                                <span class="badge bg-primary fs-6">{{ $student->admission_number ?? 'N/A' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">School</label>
                                            <p class="fs-6">{{ $student->school->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Class</label>
                                            <p class="fs-6">{{ $student->class ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Section</label>
                                            <p>{{ $student->section ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Roll Number</label>
                                            <p>{{ $student->roll_number ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Admission Date</label>
                                            <p>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Date of Birth</label>
                                            <p>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Gender</label>
                                            <p>{{ $student->gender ? ucfirst($student->gender) : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Blood Group</label>
                                            <p>{{ $student->blood_group ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Email</label>
                                            <p class="fs-6">{{ $student->email ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Phone</label>
                                            <p>{{ $student->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Parent Name</label>
                                            <p>{{ $student->parent_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Parent Email</label>
                                            <p>{{ $student->parent_email ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Parent Phone</label>
                                            <p>{{ $student->parent_phone ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Address</label>
                                            <p class="text-muted">{{ $student->address ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Created At</label>
                                            <p>{{ $student->created_at ? $student->created_at->format('F d, Y h:i A') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Last Updated</label>
                                            <p>{{ $student->updated_at ? $student->updated_at->format('F d, Y h:i A') : 'N/A' }}</p>
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
