@extends('layouts.master')
@section('title', 'Create Notification Template')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Notification Template</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.notification-template.index') }}">Templates</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Template</h5>
                            <a href="{{ route('school-admin.notification-template.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.notification-template.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name')" required autofocus placeholder="Enter template name" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="subject" class="form-label">Email Subject <span class="text-danger">*</span></label>
                                        <x-input type="text" name="subject" id="subject" :value="old('subject')" required placeholder="Enter email subject" />
                                        <small class="text-muted">You can use variables: @{{name}}, @{{email}}, @{{role}}</small>
                                        @error('subject')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="body" class="form-label">Email Body <span class="text-danger">*</span></label>
                                        <x-textarea name="body" id="body" rows="10" required placeholder="Enter email body">{{ old('body') }}</x-textarea>
                                        <small class="text-muted">You can use variables: @{{name}}, @{{email}}, @{{role}}, @{{first_name}}, @{{last_name}}</small>
                                        @error('body')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Create Template</button>
                                    <a href="{{ route('school-admin.notification-template.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

