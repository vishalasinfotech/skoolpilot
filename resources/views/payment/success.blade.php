@extends('layouts.master')
@section('title', 'Payment Success')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                colors="primary:#08a88a,secondary:#08a88a" style="width:120px;height:120px">
                            </lord-icon>
                        </div>
                        <h4 class="mb-3 text-success">Payment Successful!</h4>
                        <p class="text-muted mb-4">
                            Your subscription has been activated successfully. You can now access all the features of your plan.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="ri-home-line me-2"></i>Go to Dashboard
                            </a>
                            <a href="{{ route('subscription-plan.plans') }}" class="btn btn-outline-primary">
                                <i class="ri-list-check me-2"></i>View Plans
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

