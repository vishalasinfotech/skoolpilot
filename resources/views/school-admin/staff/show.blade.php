@extends('layouts.master')
@section('title', 'Staff Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Staff Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('school-admin.staff.index') }}">Staff</a>
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
                            <h5 class="card-title mb-0">Staff Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.staff.edit', $staff->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-fill"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.staff.index') }}" class="btn btn-secondary btn-sm">
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
                                        $imagePath = $staff->profile_image ? public_path($staff->profile_image) : null;
                                    @endphp
                                    @if($staff->profile_image && $imagePath && file_exists($imagePath))
                                        <img src="{{ asset($staff->profile_image) }}" alt="{{ $staff->first_name }} {{ $staff->last_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ $defaultImage }}" alt="{{ $staff->first_name }} {{ $staff->last_name }}"
                                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                                    <div>
                                        @if($staff->is_active)
                                            <span class="badge bg-success-subtle text-success fs-6">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fs-6">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Staff Details -->
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Full Name</label>
                                            <p class="fs-5 fw-medium">{{ $staff->first_name ?? 'N/A' }} {{ $staff->last_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Employee ID</label>
                                            <p>
                                                <span class="badge bg-primary fs-6">{{ $staff->employee_id ?? 'N/A' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">School</label>
                                            <p class="fs-6">{{ $staff->school->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Department</label>
                                            <p class="fs-6">{{ $staff->department ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Designation</label>
                                            <p>{{ $staff->designation ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Joining Date</label>
                                            <p>{{ $staff->joining_date ? \Carbon\Carbon::parse($staff->joining_date)->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Salary</label>
                                            <p>{{ $staff->salary ? number_format($staff->salary, 2) : 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Date of Birth</label>
                                            <p>{{ $staff->date_of_birth ? \Carbon\Carbon::parse($staff->date_of_birth)->format('F d, Y') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Gender</label>
                                            <p>{{ $staff->gender ? ucfirst($staff->gender) : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted fw-semibold">Phone</label>
                                            <p>{{ $staff->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Email</label>
                                            <p class="fs-6">{{ $staff->email ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Address</label>
                                            <p class="text-muted">{{ $staff->address ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Created At</label>
                                            <p>{{ $staff->created_at ? $staff->created_at->format('F d, Y h:i A') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-semibold">Last Updated</label>
                                            <p>{{ $staff->updated_at ? $staff->updated_at->format('F d, Y h:i A') : 'N/A' }}</p>
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
