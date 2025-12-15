@extends('layouts.master')
@section('title', 'Revenue Report')
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Revenue Report</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                                <li class="breadcrumb-item active">Revenue Report</li>
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
                            <form method="GET" action="{{ route('reports.super-admin.revenue') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('reports.super-admin.revenue') }}" class="btn btn-secondary">Reset</a>
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
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0">Total Revenue</p>
                                    <h4 class="mb-0 text-success">₹{{ number_format($totalRevenue, 2) }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="ri-money-dollar-circle-line fs-2 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0">Pending Amount</p>
                                    <h4 class="mb-0 text-warning">₹{{ number_format($totalPending, 2) }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="ri-time-line fs-2 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0">Failed Amount</p>
                                    <h4 class="mb-0 text-danger">₹{{ number_format($totalFailed, 2) }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-line fs-2 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Revenue Transactions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>School</th>
                                            <th>Plan</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->razorpay_order_id }}</td>
                                                <td>{{ $transaction->school->name ?? 'N/A' }}</td>
                                                <td>{{ $transaction->subscriptionPlan->name ?? 'N/A' }}</td>
                                                <td>₹{{ number_format($transaction->amount, 2) }}</td>
                                                <td>
                                                    @if($transaction->status === 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($transaction->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($transaction->payment_method ?? 'N/A') }}</td>
                                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No transactions found</td>
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

