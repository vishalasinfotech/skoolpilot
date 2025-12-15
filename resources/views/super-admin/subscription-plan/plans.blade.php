@extends('layouts.master')
@section('title', 'Current Plan')
@section('main-container')
@include('layouts.badge')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Current Plan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Current Plan</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @include('layouts.badge')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Current Plan</h5>
                    </div>
                    {{-- Properly show all plans in a layout (can style as you wish) --}}
                    <div class="card-body">
                        <div class="row">
                            @foreach($subscriptionPlans as $plan)
                                <div class="col-md-4 mb-4">
                                    <div class="card border @if($plan->is_active) border-success @else border-secondary @endif h-100">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div>
                                                <h5 class="card-title">{{ $plan->name }}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    @if($plan->price == 0 || $plan->plan_status === 'free')
                                                        <span class="badge bg-success">Free</span>
                                                    @else
                                                        @if(!empty($plan->offer_price) && $plan->offer_price < $plan->price)
                                                            <span class="fw-semibold text-danger fs-5">
                                                                ₹{{ number_format($plan->offer_price, 2) }}
                                                            </span>
                                                            <span class="text-muted text-decoration-line-through ms-2 fs-6">
                                                                ₹{{ number_format($plan->price, 2) }}
                                                            </span>
                                                        @else
                                                            <span class="fw-semibold fs-5">
                                                                ₹{{ number_format($plan->price, 2) }}
                                                            </span>
                                                        @endif
                                                        <span class="ms-1">/ {{ ucfirst($plan->billing_cycle ?? $plan->type ?? 'N/A') }}</span>
                                                    @endif
                                                </h6>
                                                <p class="card-text">{{ $plan->description }}</p>
                                                @if(!empty($plan->features) && is_array($plan->features))
                                                    <ul class="list-unstyled mt-2 mb-3">
                                                        @foreach($plan->features as $feature)
                                                            <li><i class="ri-checkbox-circle-line text-success me-1"></i> {{ $feature }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="mt-auto d-flex flex-column gap-2">
                                                @auth
                                                    <a href="{{ route('payment.checkout', $plan->id) }}" class="btn btn-sm btn-success">
                                                        <i class="ri-play-circle-line"></i>
                                                        @if($plan->plan_status === 'free' || $plan->price == 0)
                                                            Get Started Free
                                                        @else
                                                            Purchase Plan
                                                        @endif
                                                    </a>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-sm btn-success">
                                                        <i class="ri-login-box-line"></i>
                                                        Login to Purchase
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                        @if($plan->is_active)
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2">Active</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Optionally, add pagination --}}
                        @if($subscriptionPlans->hasPages())
                            <div class="mt-3">
                                <div class="dataTables_paginate paging_simple_numbers float-end">
                                    {{ $subscriptionPlans->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSubscriptionPlanModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteSubscriptionPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                <div class="mt-4">
                    <h4 class="mb-3">Delete Subscription Plan</h4>
                    <p class="text-muted mb-4">
                        Are you sure you want to delete <strong id="deleteSubscriptionPlanName"></strong>?
                        This action cannot be undone.
                    </p>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Plan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Add feature field function
        function addFeatureField(prefix = '') {
            const container = document.getElementById('features-container-' + prefix);
            const newField = document.createElement('div');
            newField.className = 'input-group mb-2';
            newField.innerHTML = `
            <input type="text" name="features[]" placeholder="Enter feature" class="form-control" />
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                <i class="ri-subtract-line"></i>
            </button>
        `;
            container.appendChild(newField);
        }

        document.addEventListener('livewire:init', function() {
            // Handle delete modal
            let deleteSubscriptionPlanId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteSubscriptionPlanId = data[0].subscriptionPlanId;
                document.getElementById('deleteSubscriptionPlanName').textContent = data[0]
                    .subscriptionPlanName;
                const modal = new bootstrap.Modal(document.getElementById('deleteSubscriptionPlanModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteSubscriptionPlanId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteSubscriptionPlanId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'deleteSubscriptionPlanModal'));
                            modal.hide();
                            deleteSubscriptionPlanId = null;
                        }
                    }
                }
            });

            // Handle success message
            Livewire.on('alert', (data) => {
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                }
            });
        });
    </script>
@endpush

@endsection
