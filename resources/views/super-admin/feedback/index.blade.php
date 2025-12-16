@extends('layouts.master')
@section('title', __('common.feedback_management'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.feedback_management') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.feedback') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.all_feedback') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('common.all_feedback') }}</h5>
                        </div>
                        @livewire('super-admin.feedback-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

