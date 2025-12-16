@extends('layouts.master')
@section('title', __('common.exam_schedule_results'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.exam_schedule_results') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('common.dashboards') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.exam_schedule_results') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <!-- Exam Schedules -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('common.exam_schedules') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.exams') }}</th>
                                            <th>{{ __('common.subjects') }}</th>
                                            <th>Exam Date</th>
                                            <th>Time</th>
                                            <th>Room Number</th>
                                            <th>{{ __('common.classes') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($examSchedules as $schedule)
                                            <tr>
                                                <td><span class="fw-medium">{{ $schedule->exam->name ?? 'N/A' }}</span></td>
                                                <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $schedule->exam_date->format('d M Y') }}</td>
                                                <td>
                                                    @if($schedule->start_time && $schedule->end_time)
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $schedule->room_number ?? 'N/A' }}</td>
                                                <td>{{ $schedule->academicClass->name ?? 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No exam schedules found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('common.results') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.exams') }}</th>
                                            <th>{{ __('common.subjects') }}</th>
                                            <th>{{ __('common.classes') }}</th>
                                            <th>Obtained Marks</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($results as $result)
                                            <tr>
                                                <td><span class="fw-medium">{{ $result->exam->name ?? 'N/A' }}</span></td>
                                                <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $result->academicClass->name ?? 'N/A' }}</td>
                                                <td>{{ $result->obtained_marks }}</td>
                                                <td>{{ $result->total_marks }}</td>
                                                <td>{{ number_format($result->percentage, 2) }}%</td>
                                                <td>{{ $result->grade }}</td>
                                                <td>
                                                    @if($result->status === 'pass')
                                                        <span class="badge bg-success">Pass</span>
                                                    @else
                                                        <span class="badge bg-danger">Fail</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No results found</td>
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

