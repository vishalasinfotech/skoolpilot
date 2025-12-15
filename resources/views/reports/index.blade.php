@extends('layouts.master')
@section('title', 'Reports')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Reports</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Reports</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row">
                @if($role === 'super_admin')
                    {{-- Super Admin Reports --}}
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Revenue Report</p>
                                        <h4 class="mb-2"><i class="ri-money-dollar-circle-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View revenue and financial reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.super-admin.revenue') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Schools Report</p>
                                        <h4 class="mb-2"><i class="ri-building-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View all schools and their details</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.super-admin.schools') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Transactions Report</p>
                                        <h4 class="mb-2"><i class="ri-exchange-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View all payment transactions</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.super-admin.transactions') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @elseif($role === 'school_admin')
                    {{-- School Admin Reports --}}
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Students Report</p>
                                        <h4 class="mb-2"><i class="ri-group-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View all students information</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.students') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Teachers Report</p>
                                        <h4 class="mb-2"><i class="ri-user-3-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View all teachers information</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.teachers') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Staff Report</p>
                                        <h4 class="mb-2"><i class="ri-team-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View all staff information</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.staff') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Attendance Report</p>
                                        <h4 class="mb-2"><i class="ri-calendar-check-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View attendance reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.attendance') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Fees Report</p>
                                        <h4 class="mb-2"><i class="ri-money-dollar-circle-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View fee collection reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.fees') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Exam & Results Report</p>
                                        <h4 class="mb-2"><i class="ri-file-list-3-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View exam and results reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.exam-results') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Library Report</p>
                                        <h4 class="mb-2"><i class="ri-book-open-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View library book issues and returns</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.school-admin.library') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @elseif($role === 'teacher')
                    {{-- Teacher Reports --}}
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Class Students Report</p>
                                        <h4 class="mb-2"><i class="ri-group-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View students in your classes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.teacher.class-students') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Attendance Report</p>
                                        <h4 class="mb-2"><i class="ri-calendar-check-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View student attendance reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.teacher.attendance') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <p class="text-truncate font-size-14 mb-2">Results Report</p>
                                        <h4 class="mb-2"><i class="ri-file-list-3-line me-1"></i></h4>
                                        <p class="text-muted mb-0">View student results reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top py-3">
                                <a href="{{ route('reports.teacher.results') }}" class="btn btn-primary btn-sm">View Report <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

