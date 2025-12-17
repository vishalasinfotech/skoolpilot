<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\FeeCollection\StoreFeeCollectionRequest;
use App\Http\Requests\SchoolAdmin\FeeCollection\UpdateFeeCollectionRequest;
use App\Models\AcademicSession;
use App\Models\FeeStructure;
use App\Models\School;
use App\Models\StudentFeeTransaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('school-admin.fee-collection.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $students = User::where('role', 'student')
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->mapWithKeys(function ($student) {
                return [$student->id => $student->full_name.' ('.$student->admission_number.')'];
            });
        $feeStructures = FeeStructure::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('fee_name')
            ->pluck('fee_name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('school-admin.fee-collection.create', compact('schools', 'students', 'feeStructures', 'academicSessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeCollectionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['collected_by'] = auth()->id();
        $data['status'] = $request->input('status', 'completed');
        $data['school_id'] = auth()->user()->school_id;

        // Generate transaction number
        if (empty($data['transaction_number'])) {
            $data['transaction_number'] = $this->generateTransactionNumber($data['school_id']);
        }

        // Generate receipt number if not provided
        if (empty($data['receipt_number'])) {
            $data['receipt_number'] = $this->generateReceiptNumber($data['school_id']);
        }

        // Clear cheque/online fields if not applicable
        if ($data['payment_method'] !== 'cheque') {
            $data['cheque_number'] = null;
            $data['cheque_date'] = null;
        }
        if ($data['payment_method'] !== 'online') {
            $data['upi_name'] = null;
            $data['upi_id'] = null;
        }

        StudentFeeTransaction::create($data);

        return redirect()->route('school-admin.fee-collection.index')
            ->with('success', 'Fee collected successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentFeeTransaction $feeCollection)
    {
        $feeCollection->load(['student', 'feeStructure', 'academicSession', 'collectedBy', 'school']);

        return view('school-admin.fee-collection.show', compact('feeCollection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentFeeTransaction $feeCollection)
    {
        $schoolId = auth()->user()->school_id;
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $students = User::where('role', 'student')
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->mapWithKeys(function ($student) {
                return [$student->id => $student->full_name.' ('.$student->admission_number.')'];
            });
        $feeStructures = FeeStructure::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('fee_name')
            ->pluck('fee_name', 'id');
        $academicSessions = AcademicSession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->pluck('name', 'id');

        return view('school-admin.fee-collection.edit', compact('feeCollection', 'schools', 'students', 'feeStructures', 'academicSessions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeCollectionRequest $request, StudentFeeTransaction $feeCollection): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['status'] = $request->input('status', $feeCollection->status);

            // Clear cheque/online fields if not applicable
            if ($data['payment_method'] !== 'cheque') {
                $data['cheque_number'] = null;
                $data['cheque_date'] = null;
            }
            if ($data['payment_method'] !== 'online') {
                $data['upi_name'] = null;
                $data['upi_id'] = null;
            }

            $feeCollection->update($data);

            DB::commit();

            return redirect()->route('school-admin.fee-collection.index')
                ->with('success', 'Fee transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update fee transaction: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentFeeTransaction $feeCollection): RedirectResponse
    {
        $feeCollection->delete();

        return redirect()->route('school-admin.fee-collection.index')
            ->with('success', 'Fee transaction deleted successfully.');
    }

    /**
     * Generate unique transaction number.
     */
    private function generateTransactionNumber(int $schoolId): string
    {
        $prefix = 'TXN';
        $year = date('Y');
        $month = date('m');
        $schoolCode = str_pad($schoolId, 4, '0', STR_PAD_LEFT);

        $lastTransaction = StudentFeeTransaction::where('school_id', $schoolId)
            ->where('transaction_number', 'like', "{$prefix}-{$year}{$month}-{$schoolCode}-%")
            ->orderBy('transaction_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->transaction_number, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return "{$prefix}-{$year}{$month}-{$schoolCode}-{$newNumber}";
    }

    /**
     * Generate unique receipt number.
     */
    private function generateReceiptNumber(int $schoolId): string
    {
        $prefix = 'RCP';
        $year = date('Y');
        $schoolCode = str_pad($schoolId, 4, '0', STR_PAD_LEFT);

        $lastTransaction = StudentFeeTransaction::where('school_id', $schoolId)
            ->where('receipt_number', 'like', "{$prefix}-{$year}-{$schoolCode}-%")
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->receipt_number, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return "{$prefix}-{$year}-{$schoolCode}-{$newNumber}";
    }

    /**
     * Display fees for logged-in student.
     */
    public function studentIndex(): View
    {
        $student = auth()->user();
        $schoolId = $student->school_id;

        // Get fee transactions for the student
        $feeTransactions = StudentFeeTransaction::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->with(['feeStructure', 'academicSession', 'collectedBy'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Calculate totals
        $totalPaid = $feeTransactions->where('status', 'completed')->sum('amount');
        $totalPending = $feeTransactions->where('status', 'pending')->sum('amount');
        $totalDue = $feeTransactions->where('status', 'due')->sum('amount');

        return view('student.fee', compact('feeTransactions', 'totalPaid', 'totalPending', 'totalDue'));
    }
}
