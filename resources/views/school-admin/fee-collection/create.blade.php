@extends('layouts.master')
@section('title', 'Collect Fee')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Collect Fee</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.fee-collection.index') }}">Fee Collection</a></li>
                                <li class="breadcrumb-item active">Collect Fee</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Collect School Fee</h5>
                            <a href="{{ route('school-admin.fee-collection.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.fee-collection.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', auth()->user()->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                                        <x-select name="student_id" id="student_id" :options="$students" :value="old('student_id')" required placeholder="Select Student" />
                                        @error('student_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fee_structure_id" class="form-label">Fee Structure</label>
                                        <x-select name="fee_structure_id" id="fee_structure_id" :options="$feeStructures" :value="old('fee_structure_id')" placeholder="Select Fee Structure (Optional)" />
                                        @error('fee_structure_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_session_id" class="form-label">Academic Session</label>
                                        <x-select name="academic_session_id" id="academic_session_id" :options="$academicSessions" :value="old('academic_session_id')" placeholder="Select Academic Session (Optional)" />
                                        @error('academic_session_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
                                        <x-input type="date" name="transaction_date" id="transaction_date" :value="old('transaction_date', date('Y-m-d'))" required />
                                        @error('transaction_date')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                        <x-input type="number" name="amount" id="amount" step="0.01" min="0.01" :value="old('amount')" required placeholder="0.00" />
                                        @error('amount')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" id="payment_method" class="form-select" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="cheque" {{ old('payment_method') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        </select>
                                        @error('payment_method')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="receipt_number" class="form-label">Receipt Number</label>
                                        <x-input type="text" name="receipt_number" id="receipt_number" :value="old('receipt_number')" placeholder="Auto-generated if left empty" />
                                        @error('receipt_number')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cheque Fields -->
                                <div id="cheque_fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cheque_number" class="form-label">Cheque Number <span class="text-danger">*</span></label>
                                            <x-input type="text" name="cheque_number" id="cheque_number" :value="old('cheque_number')" placeholder="Enter cheque number" />
                                            @error('cheque_number')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cheque_date" class="form-label">Cheque Date <span class="text-danger">*</span></label>
                                            <x-input type="date" name="cheque_date" id="cheque_date" :value="old('cheque_date')" />
                                            @error('cheque_date')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Fields -->
                                <div id="bank_fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                            <x-input type="text" name="bank_name" id="bank_name" :value="old('bank_name')" placeholder="Enter bank name" />
                                            @error('bank_name')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bank_reference" class="form-label">Bank Reference/Transaction ID</label>
                                            <x-input type="text" name="bank_reference" id="bank_reference" :value="old('bank_reference')" placeholder="Enter bank reference or transaction ID" />
                                            @error('bank_reference')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <x-textarea name="remarks" id="remarks" rows="3" placeholder="Enter any additional remarks">{{ old('remarks') }}</x-textarea>
                                        @error('remarks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Collect Fee</button>
                                    <a href="{{ route('school-admin.fee-collection.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const chequeFields = document.getElementById('cheque_fields');
            const bankFields = document.getElementById('bank_fields');
            const chequeNumber = document.getElementById('cheque_number');
            const chequeDate = document.getElementById('cheque_date');
            const bankName = document.getElementById('bank_name');

            function togglePaymentFields() {
                const method = paymentMethod.value;
                
                if (method === 'cheque') {
                    chequeFields.style.display = 'block';
                    bankFields.style.display = 'none';
                    chequeNumber.required = true;
                    chequeDate.required = true;
                    bankName.required = false;
                } else if (method === 'bank') {
                    chequeFields.style.display = 'none';
                    bankFields.style.display = 'block';
                    chequeNumber.required = false;
                    chequeDate.required = false;
                    bankName.required = true;
                } else {
                    chequeFields.style.display = 'none';
                    bankFields.style.display = 'none';
                    chequeNumber.required = false;
                    chequeDate.required = false;
                    bankName.required = false;
                }
            }

            paymentMethod.addEventListener('change', togglePaymentFields);
            
            // Initialize on page load
            togglePaymentFields();
        });
    </script>
    @endpush
@endsection

