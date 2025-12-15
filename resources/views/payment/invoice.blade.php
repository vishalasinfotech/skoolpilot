@extends('layouts.master')
@section('title', 'Transaction Invoice')
@section('main-container')
@include('layouts.badge')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Transaction Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('payment.transaction-history') }}">Transaction History</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.badge')

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <!-- Invoice Header -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h3 class="mb-1">Invoice</h3>
                                    <p class="text-muted mb-0">Transaction #{{ $transaction->id }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="mb-3">
                                    <h5 class="mb-1">{{ $transaction->school->name ?? 'N/A' }}</h5>
                                    <p class="text-muted mb-0">{{ $transaction->school->email ?? '' }}</p>
                                    <p class="text-muted mb-0">{{ $transaction->school->phone ?? '' }}</p>
                                    <p class="text-muted mb-0">{{ $transaction->school->address ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Transaction Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Transaction Details</h6>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Transaction ID:</td>
                                            <td class="fw-medium">#{{ $transaction->id }}</td>
                                        </tr>
                                        @if($transaction->razorpay_order_id)
                                            <tr>
                                                <td class="text-muted">Order ID:</td>
                                                <td class="fw-medium">{{ $transaction->razorpay_order_id }}</td>
                                            </tr>
                                        @endif
                                        @if($transaction->razorpay_payment_id)
                                            <tr>
                                                <td class="text-muted">Payment ID:</td>
                                                <td class="fw-medium">{{ $transaction->razorpay_payment_id }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td>
                                                @if($transaction->status === 'completed')
                                                    <span class="badge bg-success-subtle text-success">Completed</span>
                                                @elseif($transaction->status === 'pending')
                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                @elseif($transaction->status === 'processing')
                                                    <span class="badge bg-info-subtle text-info">Processing</span>
                                                @elseif($transaction->status === 'failed')
                                                    <span class="badge bg-danger-subtle text-danger">Failed</span>
                                                @elseif($transaction->status === 'cancelled')
                                                    <span class="badge bg-secondary-subtle text-secondary">Cancelled</span>
                                                @elseif($transaction->status === 'refunded')
                                                    <span class="badge bg-primary-subtle text-primary">Refunded</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($transaction->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Payment Method:</td>
                                            <td class="fw-medium">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date:</td>
                                            <td class="fw-medium">{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @if($transaction->paid_at)
                                            <tr>
                                                <td class="text-muted">Paid At:</td>
                                                <td class="fw-medium">{{ $transaction->paid_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        @endif
                                        @if($transaction->expires_at)
                                            <tr>
                                                <td class="text-muted">Expires At:</td>
                                                <td class="fw-medium">
                                                    {{ $transaction->expires_at->format('d M Y, h:i A') }}
                                                    @if($transaction->expires_at->isPast())
                                                        <span class="badge bg-danger-subtle text-danger ms-2">Expired</span>
                                                    @elseif($transaction->expires_at->isToday())
                                                        <span class="badge bg-warning-subtle text-warning ms-2">Expires Today</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="text-muted">Expires At:</td>
                                                <td><span class="badge bg-primary-subtle text-primary">Lifetime</span></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Subscription Plan Details</h6>
                                <div class="border rounded p-3">
                                    <h5 class="mb-2">{{ $transaction->subscriptionPlan->name ?? 'N/A' }}</h5>
                                    <p class="text-muted mb-3">{{ $transaction->subscriptionPlan->description ?? '' }}</p>
                                    <div class="mb-2">
                                        <span class="text-muted">Plan Type:</span>
                                        <span class="fw-medium ms-2">{{ ucfirst($transaction->subscriptionPlan->type ?? 'N/A') }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Tier:</span>
                                        <span class="badge bg-info-subtle text-info ms-2">{{ ucfirst($transaction->subscriptionPlan->tier ?? 'N/A') }}</span>
                                    </div>
                                    @if($transaction->subscriptionPlan && $transaction->subscriptionPlan->features && is_array($transaction->subscriptionPlan->features))
                                        <div class="mt-3">
                                            <span class="text-muted d-block mb-2">Features:</span>
                                            <ul class="list-unstyled mb-0">
                                                @foreach($transaction->subscriptionPlan->features as $feature)
                                                    <li class="mb-1">
                                                        <i class="ri-checkbox-circle-line text-success me-2"></i>
                                                        {{ $feature }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Payment Summary -->
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">Subtotal:</td>
                                                <td class="text-end">₹{{ number_format($transaction->amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Tax:</td>
                                                <td class="text-end">₹0.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Discount:</td>
                                                <td class="text-end">₹0.00</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td class="fw-bold">Total Amount:</td>
                                                <td class="text-end fw-bold fs-5">₹{{ number_format($transaction->amount, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($transaction->failure_reason)
                            <div class="alert alert-danger mt-3">
                                <h6 class="alert-heading">Failure Reason:</h6>
                                <p class="mb-0">{{ $transaction->failure_reason }}</p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                    <i class="ri-printer-line me-2"></i> Print Invoice
                                </button>
                                <a href="{{ route('payment.transaction-history') }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line me-2"></i> Back to History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .page-title-box,
        .breadcrumb,
        .btn,
        .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

@endsection

