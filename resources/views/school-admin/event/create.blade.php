@extends('layouts.master')
@section('title', 'Add Event')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Event</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.event.index') }}">Events</a></li>
                                <li class="breadcrumb-item active">Add Event</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Create Event</h5>
                            <a href="{{ route('school-admin.event.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.event.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id')" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                                        <x-input type="text" name="title" id="title" :value="old('title')" required autofocus placeholder="Enter event title" />
                                        @error('title')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="start_date" id="start_date" :value="old('start_date')" required />
                                        @error('start_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <x-input type="date" name="end_date" id="end_date" :value="old('end_date')" />
                                        @error('end_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <x-input type="time" name="start_time" id="start_time" :value="old('start_time')" />
                                        @error('start_time')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_time" class="form-label">End Time</label>
                                        <x-input type="time" name="end_time" id="end_time" :value="old('end_time')" />
                                        @error('end_time')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="location" class="form-label">Location</label>
                                        <x-input type="text" name="location" id="location" :value="old('location')" placeholder="Enter event location" />
                                        @error('location')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter event description">{{ old('description') }}</x-textarea>
                                        @error('description')
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
                                    <button type="submit" class="btn btn-primary">Create Event</button>
                                    <a href="{{ route('school-admin.event.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

