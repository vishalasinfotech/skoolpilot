@extends('layouts.master')
@section('title', __('common.edit_subscription_plan'))
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.edit_subscription_plan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('common.subscriptions_plans') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.edit_subscription_plan') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Edit Subscription Plan Form -->
            <div class="row mt-4">
                <div class="col-lg-12 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.edit_subscription_plan') }}</h5>
                            <a href="{{ route('super-admin.subscription-plan.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('super-admin.subscription-plan.update', $subscriptionPlan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">{{ __('common.plan_name') }} <span class="text-danger">*</span></label>
                                        <x-input type="text" name="name" id="name" :value="old('name', $subscriptionPlan->name)" required autofocus placeholder="{{ __('common.enter_plan_name') }}" />
                                        @error('name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">{{ __('common.description_helping_message') }}</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="{{ __('common.enter_helpful_description') }}">{{ old('description', $subscriptionPlan->description) }}</x-textarea>
                                        @error('description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">{{ __('common.description_help_text') }}</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">{{ __('common.regular_price') }} <span class="text-danger">*</span></label>
                                        <x-input type="number" name="price" id="price" :value="old('price', $subscriptionPlan->price)" required placeholder="0.00" step="0.01" min="0" />
                                        @error('price')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="offer_price" class="form-label">{{ __('common.offer_price_optional') }}</label>
                                        <x-input type="number" name="offer_price" id="offer_price" :value="old('offer_price', $subscriptionPlan->offer_price)" placeholder="0.00" step="0.01" min="0" />
                                        @error('offer_price')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">{{ __('common.offer_price_help_text') }}</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="type" class="form-label">{{ __('common.plan_type') }} <span class="text-danger">*</span></label>
                                        <x-select name="type" id="type" :options="[
                                            'days' => __('common.days'),
                                            'monthly' => __('common.monthly'),
                                            'quarterly' => __('common.quarterly'),
                                            'yearly' => __('common.yearly'),
                                            'lifetime' => __('common.lifetime'),
                                        ]" :value="old('type', $subscriptionPlan->type)" required placeholder="{{ __('common.select_type') }}" />
                                        @error('type')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="tier" class="form-label">{{ __('common.tier') }} <span class="text-danger">*</span></label>
                                        <x-select name="tier" id="tier" :options="[
                                            'basic' => __('common.basic'),
                                            'standard' => __('common.standard'),
                                            'premium' => __('common.premium'),
                                        ]" :value="old('tier', $subscriptionPlan->tier)" required placeholder="{{ __('common.select_tier') }}" />
                                        @error('tier')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="plan_status" class="form-label">{{ __('common.plan_status') }} <span class="text-danger">*</span></label>
                                        <x-select name="plan_status" id="plan_status" :options="[
                                            'free' => __('common.free'),
                                            'paid' => __('common.paid'),
                                        ]" :value="old('plan_status', $subscriptionPlan->plan_status)" required placeholder="{{ __('common.select_status') }}" />
                                        @error('plan_status')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="trial_days" class="form-label">{{ __('common.days') }} <span class="text-danger">*</span></label>
                                        <x-input type="number" name="trial_days" id="trial_days" :value="old('trial_days', $subscriptionPlan->trial_days)" required min="0" max="365" />
                                        @error('trial_days')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="features" class="form-label">{{ __('common.features') }}</label>
                                        <div id="features-container">
                                            @if(old('features'))
                                                @foreach(old('features') as $index => $feature)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="features[]" value="{{ $feature }}" placeholder="{{ __('common.enter_feature') }}" class="form-control" />
                                                        @if($index === 0)
                                                            <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                                <i class="ri-add-line"></i> {{ __('common.add_feature') }}
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                                <i class="ri-subtract-line"></i> {{ __('common.remove') }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @elseif($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                                @foreach($subscriptionPlan->features as $index => $feature)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="features[]" value="{{ $feature }}" placeholder="{{ __('common.enter_feature') }}" class="form-control" />
                                                        @if($index === 0)
                                                            <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                                <i class="ri-add-line"></i> {{ __('common.add_feature') }}
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                                <i class="ri-subtract-line"></i> {{ __('common.remove') }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="text" name="features[]" placeholder="{{ __('common.enter_feature') }}" class="form-control" />
                                                    <button type="button" class="btn btn-outline-primary" onclick="addFeatureField()">
                                                        <i class="ri-add-line"></i> {{ __('common.add_feature') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        @error('features')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">{{ __('common.features_help_text') }}</small>
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">{{ __('common.active_status') }}</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('common.update_plan') }}</button>
                                    <a href="{{ route('super-admin.subscription-plan.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Subscription Plan Form -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @push('scripts')
    <script>
        function addFeatureField() {
            const container = document.getElementById('features-container');
            const newField = document.createElement('div');
            newField.className = 'input-group mb-2';
            newField.innerHTML = `
                <input type="text" name="features[]" placeholder="{{ __('common.enter_feature') }}" class="form-control" />
                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                    <i class="ri-subtract-line"></i> {{ __('common.remove') }}
                </button>
            `;
            container.appendChild(newField);
        }
    </script>
    @endpush
@endsection

