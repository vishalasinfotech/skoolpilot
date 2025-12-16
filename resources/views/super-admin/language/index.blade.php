@extends('layouts.master')
@section('title', __('common.language_management'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.language_management') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.super_admin') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.language_management') }}</li>
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
                            <h5 class="card-title mb-0">{{ __('common.all_languages') }}</h5>
                            <a href="{{ route('super-admin.language.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> {{ __('common.add_language') }}
                            </a>
                        </div>

                        @livewire('super-admin.language-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteLanguageModal" tabindex="-1" role="dialog" aria-labelledby="deleteLanguageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                               trigger="loop"
                               colors="primary:#121331,secondary:#08a88a"
                               style="width:120px;height:120px"></lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">{{ __('common.delete_language') }}</h4>
                        <p class="text-muted mb-4">
                            {{ __('common.are_you_sure_delete') }} <strong id="deleteLanguageName"></strong> ({{ __('common.language_code') }}: <strong id="deleteLanguageCode"></strong>)?<br>
                            {{ __('common.action_cannot_undone') }}
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('common.delete') }}</button>
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
                let deleteLanguageId = null;

                Livewire.on('openDeleteModal', (data) => {
                    deleteLanguageId = data[0].languageId;
                    document.getElementById('deleteLanguageName').textContent = data[0].languageName;
                    document.getElementById('deleteLanguageCode').textContent = data[0].languageCode.toUpperCase();
                    const modal = new bootstrap.Modal(document.getElementById('deleteLanguageModal'));
                    modal.show();
                });

                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (deleteLanguageId) {
                        const livewireElement = document.querySelector('[wire\\:id]');
                        if (livewireElement) {
                            const wireId = livewireElement.getAttribute('wire:id');
                            const component = Livewire.find(wireId);
                            if (component) {
                                component.call('delete', deleteLanguageId);
                                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteLanguageModal'));
                                if (modal) {
                                    modal.hide();
                                }
                                deleteLanguageId = null;
                            }
                        }
                    }
                });

                // Handle alert messages
                Livewire.on('alert', (data) => {
                    if (data[0].type === 'success') {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data[0].message);
                        } else {
                            alert(data[0].message);
                        }
                    } else if (data[0].type === 'error') {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data[0].message);
                        } else {
                            alert(data[0].message);
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection

