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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Student</th>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Obtained</th>
                                            <th>Total</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Status</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($results ?? [] as $index => $result)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="fw-medium">{{ $result->student->name ?? 'N/A' }}</span></td>
                                                <td>{{ $result->exam->name ?? 'N/A' }}</td>
                                                <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $result->academicClass->name ?? 'N/A' }}</td>
                                                <td class="fw-semibold">{{ $result->obtained_marks }}</td>
                                                <td>{{ $result->total_marks }}</td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">{{ number_format($result->percentage, 2) }}%</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">{{ $result->grade ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    @if($result->status === 'pass')
                                                        <span class="badge bg-success-subtle text-success">Pass</span>
                                                    @elseif($result->status === 'fail')
                                                        <span class="badge bg-danger-subtle text-danger">Fail</span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning">Absent</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.result.show', $result->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.result.edit', $result->id) }}">
                                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('school-admin.result.destroy', $result->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this result?')">
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
                                                <td colspan="11" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-inbox-line fs-2"></i>
                                                        <p class="mt-2 mb-0">No results found</p>
                                                        <a href="{{ route('school-admin.result.create') }}" class="btn btn-primary btn-sm mt-2">Add First Result</a>
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
