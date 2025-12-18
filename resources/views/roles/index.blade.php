@extends('layouts.master')
@section('title', __('common.permission_management'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.permission_management') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.super_admin') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.permission_management') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('common.all_roles') }}</h5>
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> {{ __('common.add_role') }}
                            </a>
                        </div>

                        @livewire('super-admin.role-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                        trigger="loop"
                        colors="primary:#121331,secondary:#08a88a"
                        style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">{{ __('common.delete_role') }}</h4>
                        <p class="text-muted mb-4">
                            {{ __('common.are_you_sure_delete') }} <strong id="deleteRoleName"></strong>?<br>
                            {{ __('common.action_cannot_undone') }}
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteRoleBtn">{{ __('common.delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', function () {
                let deleteRoleId = null;

                Livewire.on('openDeleteModal', (data) => {
                    deleteRoleId = data[0].roleId;
                    document.getElementById('deleteRoleName').textContent = data[0].roleName;
                    const modal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
                    modal.show();
                });

                document.getElementById('confirmDeleteRoleBtn').addEventListener('click', function () {
                    if (!deleteRoleId) {
                        return;
                    }

                    const livewireElement = document.querySelector('[wire\\:id]');
                    if (!livewireElement) {
                        return;
                    }

                    const wireId = livewireElement.getAttribute('wire:id');
                    const component = Livewire.find(wireId);

                    if (!component) {
                        return;
                    }

                    component.call('delete', deleteRoleId);

                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRoleModal'));
                    if (modal) {
                        modal.hide();
                    }

                    deleteRoleId = null;
                });

                Livewire.on('alert', (data) => {
                    const type = data[0].type;
                    const message = data[0].message;

                    if (typeof toastr === 'undefined') {
                        alert(message);
                        return;
                    }

                    if (type === 'success') {
                        toastr.success(message);
                    }

                    if (type === 'error') {
                        toastr.error(message);
                    }
                });
            });
        </script>
    @endpush

@endsection

