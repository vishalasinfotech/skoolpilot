@extends('layouts.master')
@section('title', 'Vehicle Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Vehicle Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.transportation.index') }}">Transportation</a></li>
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
                            <h5 class="card-title mb-0">Vehicle Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.transportation.edit', $transportation->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.transportation.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Vehicle Number</label>
                                    <p class="mb-0">{{ $transportation->vehicle_number }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Vehicle Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info-subtle text-info">{{ ucfirst($transportation->vehicle_type) }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Driver Name</label>
                                    <p class="mb-0">{{ $transportation->driver_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Driver Phone</label>
                                    <p class="mb-0">{{ $transportation->driver_phone }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Driver License Number</label>
                                    <p class="mb-0">{{ $transportation->driver_license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Capacity</label>
                                    <p class="mb-0">{{ $transportation->capacity }} seats</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Route Name</label>
                                    <p class="mb-0">{{ $transportation->route_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Fare Amount</label>
                                    <p class="mb-0">{{ $transportation->fare_amount ? '₹' . number_format($transportation->fare_amount, 2) : 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Registration Date</label>
                                    <p class="mb-0">{{ $transportation->registration_date ? $transportation->registration_date->format('d M Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Insurance Expiry</label>
                                    <p class="mb-0">
                                        @if($transportation->insurance_expiry)
                                            {{ $transportation->insurance_expiry->format('d M Y') }}
                                            @if($transportation->insurance_expiry->isPast())
                                                <span class="badge bg-danger-subtle text-danger ms-2">Expired</span>
                                            @elseif($transportation->insurance_expiry->isBefore(now()->addDays(30)))
                                                <span class="badge bg-warning-subtle text-warning ms-2">Expiring Soon</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($transportation->is_active)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $transportation->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>

                            @if($transportation->route_description)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Route Description</label>
                                    <p class="mb-0">{{ $transportation->route_description }}</p>
                                </div>
                            </div>
                            @endif

                            @if($transportation->notes)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Notes</label>
                                    <p class="mb-0">{{ $transportation->notes }}</p>
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

