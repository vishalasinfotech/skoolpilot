@extends('layouts.master')
@section('title', __('common.promotions'))
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('common.promotions') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.student.index') }}">{{ __('common.students') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('common.promotions') }}</li>
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
                            <h5 class="card-title mb-0">{{ __('common.promotions') }}</h5>
                            <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> {{ __('common.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('school-admin.promotions.store') }}" method="POST">
                                @csrf

                                <div class="alert alert-warning">
                                    This will update <strong>all students</strong> in the selected From Class/Section.
                                    Leave <strong>To Section</strong> empty to keep the current section.
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <x-select
                                            name="from_academic_session_id"
                                            label="From Academic Session (Current Year)"
                                            :options="$sessions"
                                            :value="old('from_academic_session_id', $currentSessionId)"
                                            placeholder="Select Academic Session"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <x-select
                                            name="to_academic_session_id"
                                            label="To Academic Session (Next Year)"
                                            :options="$sessions"
                                            :value="old('to_academic_session_id')"
                                            placeholder="Select Academic Session"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">From</h6>
                                        <x-select
                                            name="from_class_id"
                                            label="Class"
                                            :options="$classes"
                                            :value="old('from_class_id')"
                                            placeholder="Select From Class"
                                            required
                                        />
                                        <x-select
                                            name="from_section_id"
                                            label="Section (optional)"
                                            :options="$sections"
                                            :value="old('from_section_id')"
                                            placeholder="All Sections"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="mb-3">To</h6>
                                        <x-select
                                            name="to_class_id"
                                            label="Class"
                                            :options="$classes"
                                            :value="old('to_class_id')"
                                            placeholder="Select To Class"
                                            required
                                        />
                                        <x-select
                                            name="to_section_id"
                                            label="Section (optional)"
                                            :options="$sections"
                                            :value="old('to_section_id')"
                                            placeholder="Keep Current Section"
                                        />
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="include_inactive"
                                        name="include_inactive"
                                        value="1"
                                        {{ old('include_inactive') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label ms-2" for="include_inactive">Include inactive students</label>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-arrow-up-circle-line align-middle me-1"></i> Promote Students
                                    </button>
                                    <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


