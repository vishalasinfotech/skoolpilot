@extends('layouts.master')
@section('title', 'Attendance Management')
@section('main-container')
    @php
        // Redirect to appropriate view based on role, default to student
        $viewRole = $role ?? 'student';
    @endphp

    @if(isset($users))
        {{-- If users are set, redirect to specific view --}}
        @if($viewRole === 'student')
            @include('school-admin.attendance.student')
        @elseif($viewRole === 'teacher')
            @include('school-admin.attendance.teacher')
        @elseif($viewRole === 'staff')
            @include('school-admin.attendance.staff')
        @else
            @include('school-admin.attendance.student')
        @endif
    @else
        {{-- Landing page to select attendance type --}}
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Attendance Management</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                    <li class="breadcrumb-item active">Manage Attendance</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.badge')

                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm bg-soft-success rounded">
                                            <span class="avatar-title bg-success rounded-circle">
                                                <i class="ri-graduation-cap-line fs-20 text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Student</p>
                                        <h5 class="mb-0">Attendance</h5>
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <a href="{{ route('school-admin.attendance.index', ['role' => 'student']) }}" class="btn btn-success w-100">
                                        <i class="ri-arrow-right-line align-middle me-1"></i> Manage Student Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm bg-soft-primary rounded">
                                            <span class="avatar-title bg-primary rounded-circle">
                                                <i class="ri-user-3-line fs-20 text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Teacher</p>
                                        <h5 class="mb-0">Attendance</h5>
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <a href="{{ route('school-admin.attendance.index', ['role' => 'teacher']) }}" class="btn btn-primary w-100">
                                        <i class="ri-arrow-right-line align-middle me-1"></i> Manage Teacher Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm bg-soft-info rounded">
                                            <span class="avatar-title bg-info rounded-circle">
                                                <i class="ri-team-line fs-20 text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Staff</p>
                                        <h5 class="mb-0">Attendance</h5>
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <a href="{{ route('school-admin.attendance.index', ['role' => 'staff']) }}" class="btn btn-info w-100">
                                        <i class="ri-arrow-right-line align-middle me-1"></i> Manage Staff Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

