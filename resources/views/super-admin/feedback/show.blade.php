@extends('layouts.master')
@section('title', 'Feedback Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Feedback Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('super-admin.feedback.index') }}">Feedback</a></li>
                                <li class="breadcrumb-item active">Feedback Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Feedback Details</h5>
                            <a href="{{ route('super-admin.feedback.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Feedback Information</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Subject:</strong></td>
                                            <td>{{ $feedback->subject }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type:</strong></td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info">
                                                    {{ ucfirst($feedback->type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($feedback->status === 'pending')
                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                @elseif($feedback->status === 'in_progress')
                                                    <span class="badge bg-primary-subtle text-primary">In Progress</span>
                                                @elseif($feedback->status === 'resolved')
                                                    <span class="badge bg-success-subtle text-success">Resolved</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created By:</strong></td>
                                            <td>{{ $feedback->createdBy->full_name ?? $feedback->createdBy->name ?? 'N/A' }} ({{ $feedback->createdBy->email ?? 'N/A' }})</td>
                                        </tr>
                                        @if($feedback->school)
                                        <tr>
                                            <td><strong>School:</strong></td>
                                            <td>{{ $feedback->school->name }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Created At:</strong></td>
                                            <td>{{ $feedback->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        @if($feedback->responded_at)
                                        <tr>
                                            <td><strong>Responded At:</strong></td>
                                            <td>{{ $feedback->responded_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">Message</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $feedback->message }}
                                    </div>
                                </div>
                            </div>

                            @if($feedback->admin_response)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">Admin Response</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $feedback->admin_response }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            <form action="{{ route('super-admin.feedback.update', $feedback->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <x-select name="status" id="status" :options="['pending' => 'Pending', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed']" :value="old('status', $feedback->status)" required />
                                        @error('status')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="admin_response" class="form-label">Admin Response</label>
                                        <x-textarea name="admin_response" id="admin_response" rows="5" placeholder="Enter your response to this feedback">{{ old('admin_response', $feedback->admin_response) }}</x-textarea>
                                        @error('admin_response')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Feedback</button>
                                    <a href="{{ route('super-admin.feedback.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

