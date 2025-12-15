@extends('layouts.master')
@section('title', 'Results Report')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Results Report</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                                <li class="breadcrumb-item active">Results Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('reports.teacher.results') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Exam</label>
                                    <select name="exam_id" class="form-select">
                                        <option value="">All Exams</option>
                                        @foreach($exams as $id => $name)
                                            <option value="{{ $id }}" {{ $examId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Class</label>
                                    <select name="class_id" class="form-select">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $id => $name)
                                            <option value="{{ $id }}" {{ $classId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Academic Session</label>
                                    <select name="academic_session_id" class="form-select">
                                        <option value="">All Sessions</option>
                                        @foreach($academicSessions as $id => $name)
                                            <option value="{{ $id }}" {{ $academicSessionId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('reports.teacher.results') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Results List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th>Class</th>
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
                                                <td>{{ $result->student->name }}</td>
                                                <td>{{ $result->exam->name }}</td>
                                                <td>{{ $result->subject->name }}</td>
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
                                                <td colspan="9" class="text-center">No results found</td>
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

