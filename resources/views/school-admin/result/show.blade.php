@extends('layouts.master')
@section('title', 'Result Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Result Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.result.index') }}">Results</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Result Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.result.edit', $result->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.result.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Student</label>
                                    <p class="mb-0">{{ $result->student->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Exam</label>
                                    <p class="mb-0">{{ $result->exam->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Subject</label>
                                    <p class="mb-0">{{ $result->subject->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Academic Session</label>
                                    <p class="mb-0">{{ $result->academicSession->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <p class="mb-0">{{ $result->academicClass->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Section</label>
                                    <p class="mb-0">{{ $result->section->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($result->status === 'pass')
                                            <span class="badge bg-success-subtle text-success">Pass</span>
                                        @elseif($result->status === 'fail')
                                            <span class="badge bg-danger-subtle text-danger">Fail</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Absent</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Obtained Marks</label>
                                    <p class="mb-0 fs-4 fw-bold text-primary">{{ $result->obtained_marks }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Total Marks</label>
                                    <p class="mb-0 fs-4 fw-bold">{{ $result->total_marks }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Percentage</label>
                                    <p class="mb-0 fs-4 fw-bold text-info">{{ number_format($result->percentage ?? 0, 2) }}%</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Grade</label>
                                    <p class="mb-0">
                                        @if($result->grade)
                                            <span class="badge bg-primary-subtle text-primary fs-6">{{ $result->grade }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Entered By</label>
                                    <p class="mb-0">{{ $result->enteredBy->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            @if($result->remarks)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Remarks</label>
                                    <p class="mb-0">{{ $result->remarks }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $result->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Updated At</label>
                                    <p class="mb-0">{{ $result->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

