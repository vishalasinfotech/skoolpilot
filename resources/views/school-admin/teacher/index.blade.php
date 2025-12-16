@extends('layouts.master')
@section('title', __('common.teacher_management'))
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.teacher_management') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.teachers') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.all_teachers') }}</li>
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
                            <h5 class="card-title mb-0">{{ __('common.all_teachers') }}</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.teacher.bulk-import') }}" class="btn btn-success">
                                    <i class="ri-upload-line align-middle me-1"></i> {{ __('common.bulk_import') }}
                                </a>
                                <a href="{{ route('school-admin.teacher.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line align-middle me-1"></i> {{ __('common.add_teacher') }}
                                </a>
                            </div>
                        </div>
                        @livewire('school-admin.teacher-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteTeacherModal" tabindex="-1" role="dialog" aria-labelledby="deleteTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">{{ __('common.delete_teacher') }}</h4>
                        <p class="text-muted mb-4">
                            {{ __('common.are_you_sure_delete') }} <strong id="deleteTeacherName"></strong>?<br>
                            {{ __('common.action_cannot_undone') }}
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('common.delete_teacher') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            let deleteTeacherId = null;

            Livewire.on('openDeleteModal', (data) => {
                deleteTeacherId = data[0].teacherId;
                document.getElementById('deleteTeacherName').textContent = data[0].teacherName;
                const modal = new bootstrap.Modal(document.getElementById('deleteTeacherModal'));
                modal.show();
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteTeacherId) {
                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (livewireElement) {
                        const wireId = livewireElement.getAttribute('wire:id');
                        const component = Livewire.find(wireId);
                        if (component) {
                            component.call('delete', deleteTeacherId);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteTeacherModal'));
                            modal.hide();
                            deleteTeacherId = null;
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

