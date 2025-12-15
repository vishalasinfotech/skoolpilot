@extends('layouts.master')
@section('title', 'Fee Transaction Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Fee Transaction Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.fee-collection.index') }}">Fee Collection</a></li>
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
                            <h5 class="card-title mb-0">Transaction Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.fee-collection.edit', $feeCollection->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.fee-collection.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Transaction Number</label>
                                    <p class="mb-0">{{ $feeCollection->transaction_number }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Receipt Number</label>
                                    <p class="mb-0">{{ $feeCollection->receipt_number ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Student</label>
                                    <p class="mb-0">
                                        {{ $feeCollection->student->full_name ?? 'N/A' }}
                                        @if($feeCollection->student)
                                            <br><small class="text-muted">Admission: {{ $feeCollection->student->admission_number }}</small>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">School</label>
                                    <p class="mb-0">{{ $feeCollection->school->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Fee Structure</label>
                                    <p class="mb-0">{{ $feeCollection->feeStructure->fee_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Academic Session</label>
                                    <p class="mb-0">{{ $feeCollection->academicSession->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Transaction Date</label>
                                    <p class="mb-0">{{ $feeCollection->transaction_date->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Amount</label>
                                    <p class="mb-0 fs-5 fw-bold text-primary">₹{{ number_format($feeCollection->amount, 2) }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Payment Method</label>
                                    <p class="mb-0">
                                        @if($feeCollection->payment_method === 'cash')
                                            <span class="badge bg-success-subtle text-success">Cash</span>
                                        @elseif($feeCollection->payment_method === 'bank')
                                            <span class="badge bg-info-subtle text-info">Bank Transfer</span>
                                        @elseif($feeCollection->payment_method === 'cheque')
                                            <span class="badge bg-warning-subtle text-warning">Cheque</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($feeCollection->status === 'completed')
                                            <span class="badge bg-success-subtle text-success">Completed</span>
                                        @elseif($feeCollection->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($feeCollection->payment_method === 'cheque')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Cheque Number</label>
                                    <p class="mb-0">{{ $feeCollection->cheque_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Cheque Date</label>
                                    <p class="mb-0">{{ $feeCollection->cheque_date ? $feeCollection->cheque_date->format('d M Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            @endif

                            @if($feeCollection->payment_method === 'bank')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Bank Name</label>
                                    <p class="mb-0">{{ $feeCollection->bank_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Bank Reference</label>
                                    <p class="mb-0">{{ $feeCollection->bank_reference ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Collected By</label>
                                    <p class="mb-0">{{ $feeCollection->collectedBy->full_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $feeCollection->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>

                            @if($feeCollection->remarks)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Remarks</label>
                                    <p class="mb-0">{{ $feeCollection->remarks }}</p>
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

