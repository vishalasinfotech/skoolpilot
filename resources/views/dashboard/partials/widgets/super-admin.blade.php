{{-- Super Admin Widgets --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Schools</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-success fs-14 mb-0">
                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_schools'] ?? 0 }}">{{ $data['total_schools'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('super-admin.school.index') }}" class="text-decoration-underline">View all schools</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-building-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Active Schools</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-success fs-14 mb-0">
                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['active_schools'] ?? 0 }}">{{ $data['active_schools'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('super-admin.school.index') }}" class="text-decoration-underline">View active schools</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="ri-checkbox-circle-line text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Subscriptions</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-success fs-14 mb-0">
                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_subscriptions'] ?? 0 }}">{{ $data['total_subscriptions'] ?? 0 }}</span>
                        </h4>
                        <a href="{{ route('super-admin.subscription-plan.index') }}" class="text-decoration-underline">View plans</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="ri-price-tag-3-line text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Revenue</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-success fs-14 mb-0">
                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            ₹{{ number_format($data['total_revenue'] ?? 0, 2) }}
                        </h4>
                        <a href="{{ route('payment.transaction-history') }}" class="text-decoration-underline">View transactions</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-money-rupee-circle-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Transaction Statistics Cards --}}
<div class="row mt-3">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Transactions</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['total_transactions'] ?? 0 }}">{{ $data['total_transactions'] ?? 0 }}</span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="ri-exchange-line text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Completed</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['completed_transactions'] ?? 0 }}">{{ $data['completed_transactions'] ?? 0 }}</span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-checkbox-circle-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['pending_transactions'] ?? 0 }}">{{ $data['pending_transactions'] ?? 0 }}</span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="ri-time-line text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Failed</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span class="counter-value" data-target="{{ $data['failed_transactions'] ?? 0 }}">{{ $data['failed_transactions'] ?? 0 }}</span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                            <i class="ri-close-circle-line text-danger"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Section --}}
<div class="row mt-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Monthly Revenue Trend</h4>
            </div>
            <div class="card-body">
                <div id="monthly-revenue-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transaction Status</h4>
            </div>
            <div class="card-body">
                <div id="transaction-status-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Daily Transaction Count (Last 30 Days)</h4>
            </div>
            <div class="card-body">
                <div id="daily-transactions-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Transactions Table --}}
@if(isset($data['recent_transactions']) && $data['recent_transactions']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Transactions</h5>
                <a href="{{ route('payment.transaction-history') }}" class="btn btn-primary btn-sm">
                    <i class="ri-eye-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
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
                            @foreach($data['recent_transactions'] as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $transaction->razorpay_order_id ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $transaction->school->name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->subscriptionPlan->name ?? 'N/A' }}</td>
                                    <td>₹{{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        @if($transaction->status === 'completed')
                                            <span class="badge bg-success-subtle text-success">Completed</span>
                                        @elseif($transaction->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @elseif($transaction->status === 'failed')
                                            <span class="badge bg-danger-subtle text-danger">Failed</span>
                                        @elseif($transaction->status === 'processing')
                                            <span class="badge bg-info-subtle text-info">Processing</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($transaction->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Recent Schools Table --}}
@if(isset($data['recent_schools']) && $data['recent_schools']->count() > 0)
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Schools</h5>
                <a href="{{ route('super-admin.school.index') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_schools'] as $index => $school)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="fw-medium">{{ $school->name }}</span></td>
                                    <td>{{ $school->email }}</td>
                                    <td>{{ $school->phone }}</td>
                                    <td>
                                        @if($school->status)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $school->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Revenue Chart
        var monthlyRevenueOptions = {
            series: [{
                name: 'Revenue',
                data: @json(array_column($data['monthly_revenue'] ?? [], 'revenue'))
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#405189'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    type: 'vertical',
                    inverseColors: false,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100, 100, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: @json(array_column($data['monthly_revenue'] ?? [], 'month'))
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return '₹' + val.toLocaleString('en-IN');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '₹' + val.toLocaleString('en-IN');
                    }
                }
            }
        };
        var monthlyRevenueChart = new ApexCharts(document.querySelector("#monthly-revenue-chart"), monthlyRevenueOptions);
        monthlyRevenueChart.render();

        // Transaction Status Pie Chart
        var statusData = @json($data['status_distribution'] ?? []);
        var statusLabels = Object.keys(statusData);
        var statusValues = Object.values(statusData);
        
        var statusChartOptions = {
            series: statusValues,
            chart: {
                type: 'donut',
                height: 350
            },
            labels: statusLabels.map(function(label) {
                return label.charAt(0).toUpperCase() + label.slice(1);
            }),
            colors: ['#0ab39c', '#f7b84b', '#f06548', '#405189', '#8b75d7', '#e7e9ed'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            }
        };
        var statusChart = new ApexCharts(document.querySelector("#transaction-status-chart"), statusChartOptions);
        statusChart.render();

        // Daily Transactions Chart
        var dailyTransactionsOptions = {
            series: [{
                name: 'Transactions',
                data: @json(array_column($data['daily_transactions'] ?? [], 'count'))
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#405189'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '55%'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json(array_column($data['daily_transactions'] ?? [], 'date'))
            },
            yaxis: {
                title: {
                    text: 'Number of Transactions'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + ' transactions';
                    }
                }
            }
        };
        var dailyTransactionsChart = new ApexCharts(document.querySelector("#daily-transactions-chart"), dailyTransactionsOptions);
        dailyTransactionsChart.render();
    });
</script>
@endpush
