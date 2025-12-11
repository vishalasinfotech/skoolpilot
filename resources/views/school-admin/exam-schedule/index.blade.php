@extends('layouts.master')
@section('title', 'Exam Schedule Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Exam Schedule Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Exam Schedules</a></li>
                                <li class="breadcrumb-item active">All Schedules</li>
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
                            <h5 class="card-title mb-0">All Exam Schedules</h5>
                            <a href="{{ route('school-admin.exam-schedule.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Schedule
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Room</th>
                                            <th>Marks</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($examSchedules ?? [] as $index => $schedule)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="fw-medium">{{ $schedule->exam->name ?? 'N/A' }}</span></td>
                                                <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $schedule->academicClass->name ?? 'N/A' }}</td>
                                                <td>{{ $schedule->section->name ?? 'All' }}</td>
                                                <td>{{ $schedule->exam_date->format('d M Y') }}</td>
                                                <td>
                                                    @if($schedule->start_time && $schedule->end_time)
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $schedule->room_number ?? 'N/A' }}</td>
                                                <td>{{ $schedule->total_marks }} (Pass: {{ $schedule->passing_marks }})</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.exam-schedule.show', $schedule->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.exam-schedule.edit', $schedule->id) }}">
                                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('school-admin.exam-schedule.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this schedule?')">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-inbox-line fs-2"></i>
                                                        <p class="mt-2 mb-0">No exam schedules found</p>
                                                        <a href="{{ route('school-admin.exam-schedule.create') }}" class="btn btn-primary btn-sm mt-2">Create First Schedule</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
