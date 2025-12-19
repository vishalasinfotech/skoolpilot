@extends('layouts.master')
@section('title', 'Leave Applications Management')
@section('main-container')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Leave Applications Management</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                                <li class="breadcrumb-item active">All Applications</li>
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
                            <h5 class="card-title mb-0">All Leave Applications</h5>
                        </div>
                        @livewire('school-admin.leave-application-table')
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- End Page-content -->
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('openRejectModal', () => {
                // Modal is handled by Livewire show/hide
            });

            Livewire.on('closeRejectModal', () => {
                // Modal is handled by Livewire show/hide
            });

            Livewire.on('leaveApplicationUpdated', () => {
                // Refresh the table
                Livewire.dispatch('$refresh');
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

