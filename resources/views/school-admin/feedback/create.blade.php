@extends('layouts.master')
@section('title', 'Create Feedback')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Feedback</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.feedback.index') }}">Feedback</a></li>
                                <li class="breadcrumb-item active">Create Feedback</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Feedback</h5>
                            <a href="{{ route('school-admin.feedback.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.feedback.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <x-input type="text" name="subject" id="subject" :value="old('subject')" required autofocus placeholder="Enter feedback subject" />
                                        @error('subject')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">Type</label>
                                        <x-select name="type" id="type" :options="['general' => 'General', 'complaint' => 'Complaint', 'suggestion' => 'Suggestion', 'question' => 'Question', 'other' => 'Other']" :value="old('type', 'general')" placeholder="Select type" />
                                        @error('type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                        <x-textarea name="message" id="message" rows="6" required placeholder="Enter your feedback message">{{ old('message') }}</x-textarea>
                                        @error('message')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                    <a href="{{ route('school-admin.feedback.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

