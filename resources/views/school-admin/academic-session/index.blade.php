@extends('layouts.master')
@section('title', 'Academic Session Management')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Academic Session Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Academic Sessions</a></li>
                                <li class="breadcrumb-item active">All Sessions</li>
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
                            <h5 class="card-title mb-0">All Academic Sessions</h5>
                            <a href="{{ route('school-admin.academic-session.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-middle me-1"></i> Add Session
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Session Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>School</th>
                                            <th>Status</th>
                                            <th>Current</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($academicSessions ?? [] as $index => $session)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="fw-medium">{{ $session->name }}</span></td>
                                                <td>{{ $session->start_date->format('d M Y') }}</td>
                                                <td>{{ $session->end_date->format('d M Y') }}</td>
                                                <td>{{ $session->school->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($session->is_active)
                                                        <span class="badge bg-success-subtle text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($session->is_current)
                                                        <span class="badge bg-primary-subtle text-primary">Current</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.academic-session.show', $session->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('school-admin.academic-session.edit', $session->id) }}">
                                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('school-admin.academic-session.destroy', $session->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this session?')">
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
                                                        <p class="mt-2 mb-0">No academic sessions found</p>
                                                        <a href="{{ route('school-admin.academic-session.create') }}" class="btn btn-primary btn-sm mt-2">Create First Session</a>
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

