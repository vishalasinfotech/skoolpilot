@extends('layouts.master')
@section('title', 'Fee Collection Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Fee Collection Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fee Collection</a></li>
                                <li class="breadcrumb-item active">All Fee Collections</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">All Fee Collections</h5>
                            <a href="{{ route('school-admin.fee-collection.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Collect Fee
                            </a>
                        </div>
                        @livewire('school-admin.fee-collection-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteFeeCollectionModal" tabindex="-1" role="dialog" aria-labelledby="deleteFeeCollectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Delete Fee Transaction</h4>
                        <p class="text-muted mb-4">
                            Are you sure you want to delete transaction <strong id="deleteFeeCollectionNumber"></strong>?
                            This action cannot be undone.
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            let deleteFeeCollectionId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteFeeCollectionId = data[0].feeCollectionId;
                document.getElementById('deleteFeeCollectionNumber').textContent = data[0].feeCollectionNumber;
                const modal = new bootstrap.Modal(document.getElementById('deleteFeeCollectionModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteFeeCollectionId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteFeeCollectionId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteFeeCollectionModal'));
                            modal.hide();
                            deleteFeeCollectionId = null;
                        }
                    }
                }
            });

            Livewire.on('alert', (data) => {
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                }
            });
        });
    </script>
    @endpush
@endsection

