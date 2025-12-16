@extends('layouts.master')
@section('title', __('common.my_children'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.my_children') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('common.dashboards') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.my_children') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row">
                @forelse($children as $child)
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-md me-3">
                                        <div class="avatar-title bg-primary-subtle rounded-circle">
                                            <i class="ri-user-3-line fs-24 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $child->name }}</h5>
                                        <p class="text-muted mb-0">{{ $child->admission_number }}</p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div>
                                            <p class="text-muted mb-1">Class</p>
                                            <h6 class="mb-0">{{ $child->academicClass->name ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <p class="text-muted mb-1">Section</p>
                                            <h6 class="mb-0">{{ $child->section->name ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <p class="text-muted mb-1">Roll Number</p>
                                            <h6 class="mb-0">{{ $child->roll_number ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <p class="text-muted mb-1">Status</p>
                                            @if($child->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('parent.student-reports', ['student_id' => $child->id]) }}" class="btn btn-primary btn-sm w-100">
                                        <i class="ri-file-chart-line align-middle me-1"></i> View Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                           trigger="loop"
                                           colors="primary:#121331,secondary:#08a88a"
                                           style="width:120px;height:120px"></lord-icon>
                                <h4 class="mt-4">No Children Found</h4>
                                <p class="text-muted">You don't have any children linked to your account.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection

