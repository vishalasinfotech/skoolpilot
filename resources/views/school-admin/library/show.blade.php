@extends('layouts.master')
@section('title', 'Book Details')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Book Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.library.index') }}">Library</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Book Information</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.library.edit', $library->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="{{ route('school-admin.library.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($library->book_image)
                            <div class="row mb-4">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset($library->book_image) }}" alt="{{ $library->book_title }}" class="img-thumbnail" style="max-height: 300px;">
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Book Title</label>
                                    <p class="mb-0">{{ $library->book_title }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Author</label>
                                    <p class="mb-0">{{ $library->author }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">ISBN</label>
                                    <p class="mb-0">{{ $library->isbn ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Publisher</label>
                                    <p class="mb-0">{{ $library->publisher ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Category</label>
                                    <p class="mb-0">{{ $library->category ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Price</label>
                                    <p class="mb-0">{{ $library->price ? '₹' . number_format($library->price, 2) : 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Total Copies</label>
                                    <p class="mb-0">{{ $library->total_copies }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Available Copies</label>
                                    <p class="mb-0">
                                        <span class="badge {{ $library->available_copies > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                            {{ $library->available_copies }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <p class="mb-0">
                                        @if($library->is_active)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($library->purchase_date)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Purchase Date</label>
                                    <p class="mb-0">{{ $library->purchase_date->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="mb-0">{{ $library->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($library->description)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Description</label>
                                    <p class="mb-0">{{ $library->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

