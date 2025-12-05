@extends('layouts.master')
@section('title', 'View Subscription Plan')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Subscription Plan Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Subscription Plans</a></li>
                                <li class="breadcrumb-item active">View Plan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- View Subscription Plan Details -->
            <div class="row mt-4">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Plan Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('super-admin.subscription-plan.edit', $subscriptionPlan->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-fill"></i> Edit
                                </a>
                                <a href="{{ route('super-admin.subscription-plan.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Plan Name</label>
                                        <p class="fs-5 fw-medium">{{ $subscriptionPlan->name }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($subscriptionPlan->description)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Description</label>
                                        <p class="text-muted">{{ $subscriptionPlan->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Regular Price</label>
                                        <p class="fs-5 fw-medium text-success">${{ number_format($subscriptionPlan->price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Offer Price</label>
                                        @if($subscriptionPlan->offer_price && $subscriptionPlan->offer_price < $subscriptionPlan->price)
                                            <p class="fs-5 fw-bold text-danger">
                                                ${{ number_format($subscriptionPlan->offer_price, 2) }}
                                                <span class="badge bg-danger-subtle text-danger ms-2">SPECIAL OFFER</span>
                                            </p>
                                            <small class="text-muted">Save ${{ number_format($subscriptionPlan->price - $subscriptionPlan->offer_price, 2) }}</small>
                                        @else
                                            <p class="text-muted">No offer available</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Plan Type</label>
                                        <p>
                                            <span class="badge 
                                                @if($subscriptionPlan->plan_status === 'free') bg-success-subtle text-success
                                                @else bg-primary-subtle text-primary
                                                @endif
                                                fs-6">
                                                {{ ucfirst($subscriptionPlan->plan_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Type</label>
                                        <p>
                                            <span class="badge bg-info-subtle text-info fs-6">
                                                {{ ucfirst($subscriptionPlan->type) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Tier</label>
                                        <p>
                                            <span class="badge 
                                                @if($subscriptionPlan->tier === 'basic') bg-secondary-subtle text-secondary
                                                @elseif($subscriptionPlan->tier === 'standard') bg-primary-subtle text-primary
                                                @else bg-warning-subtle text-warning
                                                @endif
                                                fs-6">
                                                {{ ucfirst($subscriptionPlan->tier) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Trial Days</label>
                                        <p class="fs-5 fw-medium">{{ $subscriptionPlan->trial_days }} days</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Features</label>
                                        @if($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                            <ul class="list-group">
                                                @foreach($subscriptionPlan->features as $feature)
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="ri-check-line text-success me-2 fs-5"></i>
                                                        {{ $feature }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">No features added</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Status</label>
                                        <p>
                                            @if($subscriptionPlan->is_active)
                                                <span class="badge bg-success-subtle text-success fs-6">Active</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger fs-6">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-semibold">Created At</label>
                                        <p>{{ $subscriptionPlan->created_at->format('F d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($subscriptionPlan->schools && $subscriptionPlan->schools->count() > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <label class="form-label text-muted fw-semibold">Associated Schools</label>
                                            <p class="badge bg-primary fs-6">{{ $subscriptionPlan->schools->count() }} school(s)</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End View Subscription Plan Details -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection

