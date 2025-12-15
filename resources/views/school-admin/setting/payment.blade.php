@extends('layouts.master')
@section('title', 'Payment Gateway Settings')
@section('main-container')
@include('layouts.badge')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Payment Gateway Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment Gateway</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.badge')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ri-money-rupee-circle-line me-2"></i>Razorpay Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('super-admin.setting.update-payment') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Note:</strong> You can find your Razorpay API credentials in your <a href="https://dashboard.razorpay.com/app/keys" target="_blank" class="alert-link">Razorpay Dashboard</a>.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="RAZORPAY_KEY_ID" class="form-label">Razorpay Key ID <span class="text-danger">*</span></label>
                                    <input type="text" name="RAZORPAY_KEY_ID" id="RAZORPAY_KEY_ID" class="form-control" value="{{ $paymentSettings['RAZORPAY_KEY_ID'] }}" placeholder="rzp_test_xxxxxxxxxxxxx" required>
                                    <small class="text-muted">Your Razorpay API Key ID (starts with rzp_test_ or rzp_live_)</small>
                                    @error('RAZORPAY_KEY_ID')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="RAZORPAY_KEY_SECRET" class="form-label">Razorpay Key Secret <span class="text-danger">*</span></label>
                                    <input type="password" name="RAZORPAY_KEY_SECRET" id="RAZORPAY_KEY_SECRET" class="form-control" value="{{ $paymentSettings['RAZORPAY_KEY_SECRET'] }}" placeholder="Your Razorpay Secret Key" required>
                                    <small class="text-muted">Your Razorpay API Secret Key</small>
                                    @error('RAZORPAY_KEY_SECRET')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3">
                                <i class="ri-alert-line me-2"></i>
                                <strong>Security:</strong> These credentials are stored in your .env file. Make sure to keep your .env file secure and never commit it to version control.
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-2"></i>Save Payment Gateway Configuration
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="ri-close-line me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

