@extends('layouts.master')
@section('title', __('common.notification_details'))
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.notification_details') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('common.dashboards') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.notifications') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.notification_details') }}</h5>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('common.subject') }}</label>
                                    <p class="fs-5 mb-0">{{ $notification->title }}</p>
                                </div>

                                @if($notification->sender)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">{{ __('common.created_by') }}</label>
                                        <p class="mb-0">{{ $notification->sender->name }}</p>
                                    </div>
                                @endif

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">{{ __('common.created_at') }}</label>
                                    <p class="mb-0">{{ $notification->sent_at ? $notification->sent_at->format('M d, Y h:i A') : $notification->created_at->format('M d, Y h:i A') }}</p>
                                </div>

                                @if($notificationRecipient->is_read && $notificationRecipient->read_at)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">{{ __('common.read_at') ?? 'Read At' }}</label>
                                        <p class="mb-0">{{ $notificationRecipient->read_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                @endif

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">{{ __('common.message') }}</label>
                                    <div class="border p-3 rounded bg-light">
                                        <div class="text-break">
                                            {!! nl2br(e($notification->message)) !!}
                                        </div>
                                    </div>
                                </div>

                                @if ($notification->url)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">URL</label>
                                        <p class="mb-0">
                                            <a href="{{ $notification->url }}" class="btn btn-primary btn-sm" target="_blank">
                                                {{ $notification->url }} <i class="ri-external-link-line"></i>
                                            </a>
                                        </p>
                                    </div>
                                @endif

                                @if ($notification->template)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">{{ __('common.template_used') ?? 'Template Used' }}</label>
                                        <p class="mb-0">{{ $notification->template->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

