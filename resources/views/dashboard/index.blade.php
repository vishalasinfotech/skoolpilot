@extends('layouts.master')
@section('title', 'Dashboard')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.badge')

        <div class="row">
            <div class="col-12">
                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">
                                        Good {{ date('H') < 12 ? 'Morning' : (date('H') < 17 ? 'Afternoon' : 'Evening') }}, {{ $user->first_name ?? $user->name }}!
                                    </h4>
                                    <p class="text-muted mb-0">Here's what's happening with your school today.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Role-based Widgets --}}
                    @if($role === 'super_admin')
                        @include('dashboard.partials.widgets.super-admin')
                    @elseif($role === 'school-admin')
                        @include('dashboard.partials.widgets.school-admin')
                    @elseif($role === 'teacher')
                        @include('dashboard.partials.widgets.teacher')
                    @elseif($role === 'student')
                        @include('dashboard.partials.widgets.student')
                    @elseif($role === 'staff')
                        @include('dashboard.partials.widgets.staff')
                    @elseif($role === 'parent')
                        @include('dashboard.partials.widgets.parent')
                    @else
                        <div class="alert alert-info">
                            <p>Welcome! Please contact administrator to assign your role.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

