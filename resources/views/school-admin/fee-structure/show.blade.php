@extends('layouts.master')
@section('title', 'Fee Structure Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Fee Structure Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.fee-structure.index') }}">Fee Structure</a></li>
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
                            <h5 class="card-title mb-0">Fee Structure Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.fee-structure.edit', $feeStructure->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.fee-structure.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Fee Name</label>
                                    <p class="mb-0">{{ $feeStructure->fee_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Fee Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-primary-subtle text-primary">{{ $feeStructure->fee_type }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">School</label>
                                    <p class="mb-0">{{ $feeStructure->school->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <p class="mb-0">{{ $feeStructure->academicClass->name ?? 'All Classes' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Amount</label>
                                    <p class="mb-0 fs-5 fw-bold text-primary">{{ number_format($feeStructure->amount, 2) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Frequency</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info-subtle text-info">{{ ucfirst(str_replace('_', ' ', $feeStructure->frequency)) }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Effective From</label>
                                    <p class="mb-0">{{ $feeStructure->effective_from ? $feeStructure->effective_from->format('d M Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Effective To</label>
                                    <p class="mb-0">{{ $feeStructure->effective_to ? $feeStructure->effective_to->format('d M Y') : 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($feeStructure->is_active)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $feeStructure->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>

                            @if($feeStructure->description)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Description</label>
                                    <p class="mb-0">{{ $feeStructure->description }}</p>
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

