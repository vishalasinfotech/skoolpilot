@extends('layouts.master')
@section('title', 'Transaction History')
@section('main-container')
@include('layouts.badge')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Transaction History</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transaction History</li>
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
                        <h5 class="card-title mb-0">All Transactions</h5>
                        <a href="{{ route('subscription-plan.plans') }}" class="btn btn-primary">
                            <i class="ri-add-line align-middle me-1"></i> Purchase Plan
                        </a>
                    </div>
                    @livewire('payment.transaction-table')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

