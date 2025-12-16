@extends('layouts.master')
@section('title', __('common.school_management'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.school_management') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.school_management') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.all_schools') }}</li>
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
                            <h5 class="card-title mb-0">{{ __('common.all_schools') }}</h5>
                            <a href="{{ route('super-admin.school.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> {{ __('common.add_school') }}
                            </a>
                        </div>

                        @livewire('super-admin.school-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSchoolModal" tabindex="-1" role="dialog" aria-labelledby="deleteSchoolModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop"
                        colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">{{ __('common.delete_school') }}</h4>
                        <p class="text-muted mb-4">
                            {{ __('common.delete_school_confirm') }} <strong id="deleteSchoolName"></strong>?<br>
                            {{ __('common.action_cannot_undone') }}
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('common.delete_school') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', function() {
                // Handle delete modal
                let deleteSchoolId = null;

                Livewire.on('openDeleteModal', (data) => {
                    deleteSchoolId = data[0].schoolId;
                    document.getElementById('deleteSchoolName').textContent = data[0].schoolName;
                    const modal = new bootstrap.Modal(document.getElementById('deleteSchoolModal'));
                    modal.show();
                });

                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (deleteSchoolId) {
                        const livewireElement = document.querySelector('[wire\\:id]');
                        if (livewireElement) {
                            const wireId = livewireElement.getAttribute('wire:id');
                            const component = Livewire.find(wireId);
                            if (component) {
                                component.call('delete', deleteSchoolId);
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'deleteSchoolModal'));
                                modal.hide();
                                deleteSchoolId = null;
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
