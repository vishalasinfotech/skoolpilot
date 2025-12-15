@extends('layouts.master')
@section('title', 'Library Report')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Library Report</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                                <li class="breadcrumb-item active">Library Report</li>
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
                            <form method="GET" action="{{ route('reports.school-admin.library') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                                        <option value="issued" {{ $status === 'issued' ? 'selected' : '' }}>Issued</option>
                                        <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Returned</option>
                                        <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('reports.school-admin.library') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-0">Total Issued</p>
                            <h4 class="mb-0">{{ $stats['total_issued'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-0">Total Returned</p>
                            <h4 class="mb-0 text-success">{{ $stats['total_returned'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-0">Overdue</p>
                            <h4 class="mb-0 text-danger">{{ $stats['overdue'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Book Issues</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>User</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bookIssues as $issue)
                                            <tr>
                                                <td>{{ $issue->library->title ?? 'N/A' }}</td>
                                                <td>{{ $issue->user->name }}</td>
                                                <td>{{ $issue->issue_date->format('d M Y') }}</td>
                                                <td>{{ $issue->due_date->format('d M Y') }}</td>
                                                <td>{{ $issue->return_date ? $issue->return_date->format('d M Y') : 'N/A' }}</td>
                                                <td>
                                                    @if($issue->status === 'issued')
                                                        <span class="badge bg-warning">Issued</span>
                                                    @else
                                                        <span class="badge bg-success">Returned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No book issues found</td>
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

