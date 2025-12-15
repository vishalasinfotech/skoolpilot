@extends('layouts.master')
@section('title', 'Payment Failed')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f06548,secondary:#f06548" style="width:120px;height:120px">
                            </lord-icon>
                        </div>
                        <h4 class="mb-3 text-danger">Payment Failed</h4>
                        <p class="text-muted mb-4">
                            We're sorry, but your payment could not be processed. Please try again or contact support if the problem persists.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('subscription-plan.plans') }}" class="btn btn-primary">
                                <i class="ri-arrow-left-line me-2"></i>Try Again
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="ri-home-line me-2"></i>Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

