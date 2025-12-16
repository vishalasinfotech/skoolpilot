@extends('layouts.master')
@section('title', __('common.add_school'))
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.add_school') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.pages') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.add_school') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Add School Form -->
            <div class="row mt-4">
                <div class="col-lg-12 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.create_school') }}</h5>
                            <a href="{{ route('super-admin.school.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('super-admin.school.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">{{ __('common.school_name') }} <span
                                                class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name')" required
                                            autofocus placeholder="{{ __('common.enter_school_name') }}" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">{{ __('common.email') }} <span
                                                class="text-danger">*</span></label>
                                        <x-input type="email" name="email" id="email" :value="old('email')" required
                                            placeholder="{{ __('common.enter_email_address') }}" />
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">{{ __('common.phone') }}</label>
                                        <x-input type="text" name="phone" id="phone" :value="old('phone')"
                                            placeholder="{{ __('common.enter_phone') }}" />
                                        @error('phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">{{ __('common.address') }}</label>
                                        <x-textarea name="address" id="address" rows="3"
                                            placeholder="{{ __('common.enter_address') }}">{{ old('address') }}</x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="subscription_plan_id" class="form-label">{{ __('common.subscription_plan') }}</label>
                                        <x-select name="subscription_plan_id" id="subscription_plan_id" :options="$subscriptionPlans->pluck('name', 'id')"
                                            :value="old('subscription_plan_id')" placeholder="{{ __('common.select_plan') }}" />
                                        @error('subscription_plan_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="logo" class="form-label">{{ __('common.logo') }}</label>
                                        <x-input type="file" name="logo" id="logo" accept="image/*" />
                                        @error('logo')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="theme_color" class="form-label">{{ __('common.theme_color') }} <span
                                                class="text-danger">*</span></label>
                                        <x-input type="color" name="theme_color" id="theme_color" :value="old('theme_color', '#3B82F6')"
                                            required />
                                        @error('theme_color')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input code-switcher" type="checkbox" id="9"
                                        name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="status">{{ __('common.status') }}</label>
                                </div>
                                @error('status')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('common.create_school') }}</button>
                                    <a href="{{ route('super-admin.school.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add School Form -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
