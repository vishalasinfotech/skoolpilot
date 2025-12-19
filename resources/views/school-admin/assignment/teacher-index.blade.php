@extends('layouts.master')
@section('title', 'Assignments')
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Assignments</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Classroom</a></li>
                                <li class="breadcrumb-item active">Assignments</li>
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
                            <h5 class="card-title mb-0">My Assignments</h5>
                            <div>
                                <a href="{{ route('teacher.assignment.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line align-middle me-1"></i> Create Assignment
                                </a>
                            </div>
                        </div>
                        @livewire('school-admin.teacher.assignment-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssignmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Delete Assignment</h4>
                        <p class="text-muted mb-4">
                            Are you sure you want to delete the assignment <strong id="deleteAssignmentName"></strong>?
                            This action cannot be undone.
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Assignment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            let deleteAssignmentId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteAssignmentId = data[0].assignmentId;
                document.getElementById('deleteAssignmentName').textContent = data[0].assignmentName;
                const modal = new bootstrap.Modal(document.getElementById('deleteAssignmentModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteAssignmentId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteAssignmentId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAssignmentModal'));
                            modal.hide();
                            deleteAssignmentId = null;
                        }
                    }
                }
            });

            Livewire.on('assignmentDeleted', () => {
                // Table will automatically refresh
            });

            Livewire.on('alert', (data) => {
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                }
            });
        });

        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif
    </script>
    @endpush

@endsection

