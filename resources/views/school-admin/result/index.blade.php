@extends('layouts.master')
@section('title', 'Result Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Result Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Results</a></li>
                                <li class="breadcrumb-item active">All Results</li>
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
                            <h5 class="card-title mb-0">All Results</h5>
                            <a href="{{ route('school-admin.result.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Result
                            </a>
                        </div>
                        @livewire('school-admin.result-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
