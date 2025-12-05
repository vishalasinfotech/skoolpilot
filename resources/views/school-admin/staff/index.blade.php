@extends('layouts.master')
@section('title', 'Staff Management')
@section('main-container')
@include('layouts.badge')


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Staff Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                                <li class="breadcrumb-item active">All Staff</li>
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
                            <h5 class="card-title mb-0">All Staff</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.staff.bulk-import') }}" class="btn btn-success">
                                    <i class="ri-upload-line align-middle me-1"></i> Bulk Import
                                </a>
                                <a href="{{ route('school-admin.staff.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line align-middle me-1"></i> Add Staff
                                </a>
                            </div>
                        </div>
                        @livewire('school-admin.staff-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteStaffModal" tabindex="-1" role="dialog" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Delete Staff</h4>
                        <p class="text-muted mb-4">
                            Are you sure you want to delete <strong id="deleteStaffName"></strong>?
                            This action cannot be undone.
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Staff</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            let deleteStaffId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteStaffId = data[0].staffId;
                document.getElementById('deleteStaffName').textContent = data[0].staffName;
                const modal = new bootstrap.Modal(document.getElementById('deleteStaffModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteStaffId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteStaffId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteStaffModal'));
                            modal.hide();
                            deleteStaffId = null;
                        }
                    }
                }
            });

            Livewire.on('alert', (data) => {
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                }
            });
        });
    </script>
    @endpush

@endsection
