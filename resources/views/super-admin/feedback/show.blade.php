@extends('layouts.master')
@section('title', __('common.feedback_details'))
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.feedback_details') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('super-admin.feedback.index') }}">{{ __('common.feedback') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.feedback_details') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.feedback_details') }}</h5>
                            <a href="{{ route('super-admin.feedback.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">{{ __('common.feedback_information') }}</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>{{ __('common.subject') }}:</strong></td>
                                            <td>{{ $feedback->subject }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('common.type') }}:</strong></td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info">
                                                    {{ ucfirst($feedback->type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('common.status') }}:</strong></td>
                                            <td>
                                                @if($feedback->status === 'pending')
                                                    <span class="badge bg-warning-subtle text-warning">{{ __('common.pending') }}</span>
                                                @elseif($feedback->status === 'in_progress')
                                                    <span class="badge bg-primary-subtle text-primary">{{ __('common.in_progress') }}</span>
                                                @elseif($feedback->status === 'resolved')
                                                    <span class="badge bg-success-subtle text-success">{{ __('common.resolved') }}</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">{{ __('common.closed') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('common.created_by') }}:</strong></td>
                                            <td>{{ $feedback->createdBy->full_name ?? $feedback->createdBy->name ?? 'N/A' }} ({{ $feedback->createdBy->email ?? 'N/A' }})</td>
                                        </tr>
                                        @if($feedback->school)
                                        <tr>
                                            <td><strong>{{ __('common.all_schools') }}:</strong></td>
                                            <td>{{ $feedback->school->name }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>{{ __('common.created_at') }}:</strong></td>
                                            <td>{{ $feedback->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        @if($feedback->responded_at)
                                        <tr>
                                            <td><strong>{{ __('common.responded_at') }}:</strong></td>
                                            <td>{{ $feedback->responded_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">{{ __('common.message') }}</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $feedback->message }}
                                    </div>
                                </div>
                            </div>

                            @if($feedback->admin_response)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">{{ __('common.admin_response') }}</h6>
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
                                        <label for="status" class="form-label">{{ __('common.status') }} <span class="text-danger">*</span></label>
                                        <x-select name="status" id="status" :options="['pending' => __('common.pending'), 'in_progress' => __('common.in_progress'), 'resolved' => __('common.resolved'), 'closed' => __('common.closed')]" :value="old('status', $feedback->status)" required />
                                        @error('status')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="admin_response" class="form-label">{{ __('common.admin_response') }}</label>
                                        <x-textarea name="admin_response" id="admin_response" rows="5" placeholder="{{ __('common.enter_your_response') }}">{{ old('admin_response', $feedback->admin_response) }}</x-textarea>
                                        @error('admin_response')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('common.update_feedback') }}</button>
                                    <a href="{{ route('super-admin.feedback.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

