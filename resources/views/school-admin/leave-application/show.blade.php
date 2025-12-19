@extends('layouts.master')
@section('title', 'Leave Application Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Leave Application Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.leave-application.index') }}">Leave Applications</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Leave Application Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.leave-application.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Teacher</label>
                                    <p class="mb-0">{{ $leaveApplication->teacher?->full_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Leave Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-primary-subtle text-primary text-capitalize">{{ $leaveApplication->leave_type }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info-subtle text-info text-capitalize">{{ str_replace('_', ' ', $leaveApplication->type) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($leaveApplication->status === 'approved')
                                            <span class="badge bg-success-subtle text-success">Approved</span>
                                        @elseif($leaveApplication->status === 'rejected')
                                            <span class="badge bg-danger-subtle text-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Start Date</label>
                                    <p class="mb-0">
                                        {{ $leaveApplication->start_date ? \Carbon\Carbon::parse($leaveApplication->start_date)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">End Date</label>
                                    <p class="mb-0">
                                        {{ $leaveApplication->end_date ? \Carbon\Carbon::parse($leaveApplication->end_date)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Applied On</label>
                                    <p class="mb-0">
                                        {{ $leaveApplication->created_at ? $leaveApplication->created_at->format('d M Y, h:i A') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    @if($leaveApplication->updated_at && $leaveApplication->updated_at->ne($leaveApplication->created_at))
                                        <label class="form-label fw-semibold">Last Updated</label>
                                        <p class="mb-0">{{ $leaveApplication->updated_at->format('d M Y, h:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Reason</label>
                                    <p class="mb-0">{{ $leaveApplication->reason }}</p>
                                </div>
                            </div>

                            @if($leaveApplication->remarks)
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-semibold">Remarks</label>
                                        <p class="mb-0">{{ $leaveApplication->remarks }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
