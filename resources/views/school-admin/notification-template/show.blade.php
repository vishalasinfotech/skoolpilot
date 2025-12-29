@extends('layouts.master')
@section('title', 'View Notification Template')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">View Notification Template</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.notification-template.index') }}">Templates</a></li>
                                <li class="breadcrumb-item active">View</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Template Details</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.notification-template.edit', $notificationTemplate) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.notification-template.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Template Name</label>
                                    <p>{{ $notificationTemplate->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <p>
                                        @if($notificationTemplate->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Email Subject</label>
                                    <p>{{ $notificationTemplate->subject }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Email Body</label>
                                    <div class="border p-3 rounded bg-light">
                                        {!! nl2br(e($notificationTemplate->body)) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Created At</label>
                                    <p>{{ $notificationTemplate->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Updated At</label>
                                    <p>{{ $notificationTemplate->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

