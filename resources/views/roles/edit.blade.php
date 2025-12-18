@extends('layouts.master')
@section('title', __('common.edit_role'))
@section('main-container')
@include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.edit_role') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('common.permission_management') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.edit_role') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">{{ __('common.edit_role') }}</h5>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')

                            <form action="{{ route('roles.update', $role) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __('common.role_name') }} <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', $role->name) }}"
                                            placeholder="{{ __('common.role_name_placeholder') }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        @include('roles._permissions', ['permissions' => $permissions, 'rolePermissions' => $rolePermissions ?? []])
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-middle me-1"></i> {{ __('common.save') }}
                                    </button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
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

