@extends('layouts.master')
@section('title', 'Issue Book')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Issue Book</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.library.index') }}">Library</a></li>
                                <li class="breadcrumb-item active">Issue Book</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Issue Book to User</h5>
                            <a href="{{ route('school-admin.library.issued-books') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back to Issued Books
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.library.issue-book') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="library_id" class="form-label">Select Book <span class="text-danger">*</span></label>
                                        <x-select name="library_id" id="library_id" :options="$books" :value="old('library_id')" required placeholder="Select a book" />
                                        @error('library_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_id" class="form-label">Select User <span class="text-danger">*</span></label>
                                        <x-select name="user_id" id="user_id" :options="$users" :value="old('user_id')" required placeholder="Select a user (Student/Staff/Teacher)" />
                                        @error('user_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="issue_date" class="form-label">Issue Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="issue_date" id="issue_date" :value="old('issue_date', date('Y-m-d'))" required />
                                        @error('issue_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="due_date" id="due_date" :value="old('due_date')" required />
                                        @error('due_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <x-textarea name="notes" id="notes" rows="3" placeholder="Enter any additional notes (optional)">{{ old('notes') }}</x-textarea>
                                        @error('notes')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-book-open-line align-middle me-1"></i> Issue Book
                                    </button>
                                    <a href="{{ route('school-admin.library.issued-books') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

