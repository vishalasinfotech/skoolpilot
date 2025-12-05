@extends('layouts.master')
@section('title', 'Subscription Plans Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Subscription Plans Management</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Subscription Plans</a></li>
                                <li class="breadcrumb-item active">All Plans</li>
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
                            <h5 class="card-title mb-0">All Subscription Plans</h5>
                            <a href="{{ route('super-admin.subscription-plan.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Plan
                            </a>
                        </div>
                        @livewire('super-admin.subscription-plan-table')
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
