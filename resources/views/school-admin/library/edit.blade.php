@extends('layouts.master')
@section('title', 'Edit Book')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Book</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.library.index') }}">Library</a></li>
                                <li class="breadcrumb-item active">Edit Book</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Book</h5>
                            <a href="{{ route('school-admin.library.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.library.update', $library->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $library->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="book_title" class="form-label">Book Title <span class="text-danger">*</span></label>
                                        <x-input type="text" name="book_title" id="book_title" :value="old('book_title', $library->book_title)" required autofocus placeholder="Enter book title" />
                                        @error('book_title')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                                        <x-input type="text" name="author" id="author" :value="old('author', $library->author)" required placeholder="Enter author name" />
                                        @error('author')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <x-input type="text" name="isbn" id="isbn" :value="old('isbn', $library->isbn)" placeholder="Enter ISBN number" />
                                        @error('isbn')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="publisher" class="form-label">Publisher</label>
                                        <x-input type="text" name="publisher" id="publisher" :value="old('publisher', $library->publisher)" placeholder="Enter publisher name" />
                                        @error('publisher')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <x-input type="text" name="category" id="category" :value="old('category', $library->category)" placeholder="e.g., Fiction, Science, History" />
                                        @error('category')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="total_copies" class="form-label">Total Copies <span class="text-danger">*</span></label>
                                        <x-input type="number" name="total_copies" id="total_copies" :value="old('total_copies', $library->total_copies)" required min="1" />
                                        @error('total_copies')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="available_copies" class="form-label">Available Copies <span class="text-danger">*</span></label>
                                        <x-input type="number" name="available_copies" id="available_copies" :value="old('available_copies', $library->available_copies)" required min="0" />
                                        @error('available_copies')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="price" class="form-label">Price (₹)</label>
                                        <x-input type="number" name="price" id="price" :value="old('price', $library->price)" step="0.01" min="0" placeholder="0.00" />
                                        @error('price')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                        <x-input type="date" name="purchase_date" id="purchase_date" :value="old('purchase_date', $library->purchase_date ? $library->purchase_date->format('Y-m-d') : '')" />
                                        @error('purchase_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="book_image" class="form-label">Book Image</label>
                                        <input type="file" name="book_image" id="book_image" class="form-control" accept="image/*">
                                        @if($library->book_image)
                                            <small class="text-muted d-block mt-1">Current: <a href="{{ asset($library->book_image) }}" target="_blank">View Image</a></small>
                                        @endif
                                        @error('book_image')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <x-textarea name="description" id="description" rows="3" placeholder="Enter book description">{{ old('description', $library->description) }}</x-textarea>
                                        @error('description')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check form-switch form-switch-md mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $library->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active Status</label>
                                </div>
                                @error('is_active')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Book</button>
                                    <a href="{{ route('school-admin.library.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

