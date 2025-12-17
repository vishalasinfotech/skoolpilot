<?php

namespace App\Http\Requests\SchoolAdmin\FeeCollection;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'school_id' => ['required', 'exists:schools,id'],
            'student_id' => ['required', 'exists:users,id'],
            'fee_structure_id' => ['nullable', 'exists:fee_structures,id'],
            'academic_session_id' => ['nullable', 'exists:academic_sessions,id'],
            'transaction_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:cash,bank,cheque'],
            'cheque_number' => ['nullable', 'required_if:payment_method,cheque', 'string', 'max:100'],
            'cheque_date' => ['nullable', 'required_if:payment_method,cheque', 'date'],
            'bank_name' => ['nullable', 'required_if:payment_method,bank', 'string', 'max:255'],
            'bank_reference' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'receipt_number' => ['nullable', 'string', 'max:100', 'unique:student_fee_transactions,receipt_number'],
            'status' => ['nullable', 'in:pending,completed,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Please select a student.',
            'student_id.exists' => 'The selected student does not exist.',
            'transaction_date.required' => 'Transaction date is required.',
            'amount.required' => 'Amount is required.',
            'amount.min' => 'Amount must be greater than 0.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Payment method must be cash, bank, or cheque.',
            'cheque_number.required_if' => 'Cheque number is required when payment method is cheque.',
            'cheque_date.required_if' => 'Cheque date is required when payment method is cheque.',
            'bank_name.required_if' => 'Bank name is required when payment method is bank.',
            'receipt_number.unique' => 'This receipt number is already in use.',
        ];
    }
}
