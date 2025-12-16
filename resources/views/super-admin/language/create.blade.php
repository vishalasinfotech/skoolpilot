@extends('layouts.master')
@section('title', __('common.add_language'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.add_language') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('super-admin.language.index') }}">{{ __('common.language_management') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.add_language') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.add_language') }}</h5>
                            <a href="{{ route('super-admin.language.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.cancel') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('super-admin.language.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="code" class="form-label">{{ __('common.language_code') }} <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('code') is-invalid @enderror" 
                                               id="code" 
                                               name="code" 
                                               value="{{ old('code') }}"
                                               placeholder="{{ __('common.language_code_placeholder') }}"
                                               maxlength="10"
                                               required>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('common.language_code_hint') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __('common.language_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}"
                                               placeholder="{{ __('common.language_name_placeholder') }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="native_name" class="form-label">{{ __('common.native_name') }}</label>
                                        <input type="text" 
                                               class="form-control @error('native_name') is-invalid @enderror" 
                                               id="native_name" 
                                               name="native_name" 
                                               value="{{ old('native_name') }}"
                                               placeholder="{{ __('common.native_name_placeholder') }}">
                                        @error('native_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sort_order" class="form-label">{{ __('common.sort_order') }}</label>
                                        <input type="number" 
                                               class="form-control @error('sort_order') is-invalid @enderror" 
                                               id="sort_order" 
                                               name="sort_order" 
                                               value="{{ old('sort_order', 0) }}"
                                               min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('common.sort_order_hint') }}</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active"
                                                   value="1"
                                                   {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                {{ __('common.is_active') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_default" 
                                                   name="is_default"
                                                   value="1"
                                                   {{ old('is_default', false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_default">
                                                {{ __('common.is_default') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">{{ __('common.default_language_hint') }}</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-middle me-1"></i> {{ __('common.save') }}
                                    </button>
                                    <a href="{{ route('super-admin.language.index') }}" class="btn btn-secondary">
                                        <i class="ri-close-line align-middle me-1"></i> {{ __('common.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
