@extends('layouts.master')
@section('title', 'Academic Class Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Academic Class Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Academic Classes</a></li>
                                <li class="breadcrumb-item active">All Classes</li>
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
                            <h5 class="card-title mb-0">All Academic Classes</h5>
                            <a href="{{ route('school-admin.academic-class.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Class
                            </a>
                        </div>
                        @livewire('school-admin.academic-class-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAcademicClassModal" tabindex="-1" role="dialog" aria-labelledby="deleteAcademicClassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Delete Academic Class</h4>
                        <p class="text-muted mb-4">
                            Are you sure you want to delete <strong id="deleteAcademicClassName"></strong>?
                            This action cannot be undone.
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Class</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            let deleteAcademicClassId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteAcademicClassId = data[0].academicClassId;
                document.getElementById('deleteAcademicClassName').textContent = data[0].academicClassName;
                const modal = new bootstrap.Modal(document.getElementById('deleteAcademicClassModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteAcademicClassId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteAcademicClassId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAcademicClassModal'));
                            modal.hide();
                            deleteAcademicClassId = null;
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

