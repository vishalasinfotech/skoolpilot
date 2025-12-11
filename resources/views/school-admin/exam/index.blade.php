@extends('layouts.master')
@section('title', 'Exam Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Exam Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Exams</a></li>
                                <li class="breadcrumb-item active">All Exams</li>
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
                            <h5 class="card-title mb-0">All Exams</h5>
                            <a href="{{ route('school-admin.exam.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Exam
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Exam Name</th>
                                            <th>Exam Type</th>
                                            <th>Academic Session</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exams ?? [] as $index => $exam)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="fw-medium">{{ $exam->name }}</span></td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">{{ ucfirst(str_replace('_', ' ', $exam->exam_type)) }}</span>
                                                </td>
                                                <td>{{ $exam->academicSession->name ?? 'N/A' }}</td>
                                                <td>{{ $exam->start_date->format('d M Y') }}</td>
                                                <td>{{ $exam->end_date->format('d M Y') }}</td>
                                                <td>
                                                    @if($exam->is_active)
                                                        <span class="badge bg-success-subtle text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.exam.show', $exam->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.exam.edit', $exam->id) }}">
                                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('school-admin.exam.destroy', $exam->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this exam?')">
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
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-inbox-line fs-2"></i>
                                                        <p class="mt-2 mb-0">No exams found</p>
                                                        <a href="{{ route('school-admin.exam.create') }}" class="btn btn-primary btn-sm mt-2">Create First Exam</a>
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
