@extends('layouts.master')
@section('title', 'School Management')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit School</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Edit School</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Edit School Form -->
            <div class="row mt-4">
                <div class="col-lg-12 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit School</h5>
                            <a href="{{ route('super-admin.school.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('super-admin.school.update', $school->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">School Name <span
                                                class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name', $school->name)" required
                                            autofocus placeholder="Enter school name" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <x-input type="email" name="email" id="email" :value="old('email', $school->email)" required
                                            placeholder="Enter email address" />
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <x-input type="text" name="phone" id="phone" :value="old('phone', $school->phone)"
                                            placeholder="Enter phone" />
                                        @error('phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <x-textarea name="address" id="address" rows="3" :value="old('address', $school->address)"
                                            placeholder="Enter address"></x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="subscription_plan_id" class="form-label">Subscription Plan</label>
                                        <x-select name="subscription_plan_id" id="subscription_plan_id" :options="$subscriptionPlans->pluck('name', 'id')"
                                            :value="old('subscription_plan_id', $school->subscription_plan_id)" placeholder="Select Plan" />
                                        @error('subscription_plan_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="logo" class="form-label">Logo</label>
                                        <x-input type="file" name="logo" id="logo" accept="image/*" />
                                        @if ($school->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}"
                                                    class="img-thumbnail" style="max-height:60px;">
                                            </div>
                                        @endif
                                        @error('logo')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="theme_color" class="form-label">Theme Color <span
                                                class="text-danger">*</span></label>
                                        <x-input type="color" name="theme_color" id="theme_color" :value="old('theme_color', $school->theme_color ?? '#3B82F6')"
                                            required />
                                        @error('theme_color')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input code-switcher" type="checkbox" id="edit-school-status"
                                        name="status" value="1"
                                        {{ old('status', $school->status) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="edit-school-status">Status</label>
                                </div>
                                @error('status')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update School</button>
                                    <a href="{{ route('super-admin.school.index') }}"
                                        class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit School Form -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
