@extends('layouts.master')
@section('title', 'View Notification')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">View Notification</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('school-admin.notification.index') }}">Notifications</a></li>
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
                            <h5 class="card-title mb-0">Notification Details</h5>
                            <a href="{{ route('school-admin.notification.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Title</label>
                                    <p>{{ $notification->title }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Type</label>
                                    <p>
                                        @if ($notification->type === 'role')
                                            <span class="badge bg-info">By Role</span>
                                        @else
                                            <span class="badge bg-primary">Specific Users</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Message</label>
                                    <div class="border p-3 rounded bg-light">
                                        {!! nl2br(e($notification->message)) !!}
                                    </div>
                                </div>
                                @if ($notification->url)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">URL</label>
                                        <p><a href="{{ $notification->url }}" target="_blank">{{ $notification->url }}</a>
                                        </p>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Total Recipients</label>
                                    <p>{{ $notification->total_recipients }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Emails Sent</label>
                                    <p>
                                        <span class="badge bg-success">{{ $notification->emails_sent }}</span>
                                        @if ($notification->emails_failed > 0)
                                            <span class="badge bg-danger">{{ $notification->emails_failed }} failed</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Sent By</label>
                                    <p>{{ $notification->sender->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Sent At</label>
                                    <p>{{ $notification->sent_at ? $notification->sent_at->format('M d, Y h:i A') : '-' }}
                                    </p>
                                </div>
                                @if ($notification->template)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Template Used</label>
                                        <p>{{ $notification->template->name }}</p>
                                    </div>
                                @endif
                            </div>

                            @if ($notification->recipients->count() > 0)
                                <hr>
                                <h5 class="mb-3">Recipients</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Email Sent</th>
                                                <th>Read</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($notification->recipients as $recipient)
                                                <tr>
                                                    <td>{{ $recipient->user->name ?? $recipient->user->full_name }}</td>
                                                    <td>{{ $recipient->user->email }}</td>
                                                    <td><span
                                                            class="badge bg-secondary">{{ $recipient->user->role }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($recipient->email_sent)
                                                            <span class="badge bg-success">Yes</span>
                                                            @if ($recipient->email_sent_at)
                                                                <small
                                                                    class="text-muted d-block">{{ $recipient->email_sent_at->format('M d, Y h:i A') }}</small>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-danger">No</span>
                                                            @if ($recipient->email_error)
                                                                <small
                                                                    class="text-danger d-block">{{ $recipient->email_error }}</small>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($recipient->is_read)
                                                            <span class="badge bg-success">Yes</span>
                                                            @if ($recipient->read_at)
                                                                <small
                                                                    class="text-muted d-block">{{ $recipient->read_at->format('M d, Y h:i A') }}</small>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-secondary">No</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
