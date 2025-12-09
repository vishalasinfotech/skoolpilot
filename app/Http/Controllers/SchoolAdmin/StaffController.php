<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Staff\StoreStaffRequest;
use App\Http\Requests\SchoolAdmin\Staff\UpdateStaffRequest;
use App\Models\School;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('school-admin.staff.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.staff.create', compact('schools'));
    }

    public function show(User $staff)
    {
        abort_unless($staff->isStaff(), 404);

        return view('school-admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        abort_unless($staff->isStaff(), 404);

        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.staff.edit', compact('staff', 'schools'));
    }

    public function store(StoreStaffRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'staff/profiles'
            );
        }
        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'staff/docs'
            );
        }

        unset($data['password_confirmation']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['role'] = 'staff';
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        // Set default password if not provided
        if (empty($data['password'])) {
            $data['password'] = $data['employee_id'] ?? 'password123';
        }

        User::create($data);

        return redirect()->route('school-admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function update(UpdateStaffRequest $request, User $staff, ImageUploadService $imageUploadService): RedirectResponse
    {
        abort_unless($staff->isStaff(), 404);

        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'staff/profiles',
                $staff->profile_image
            );
        }

        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'staff/docs',
                $staff->doc_image
            );
        }

        unset($data['password_confirmation']);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active', false);
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));
        $staff->update($data);

        return redirect()->route('school-admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff): RedirectResponse
    {
        abort_unless($staff->isStaff(), 404);

        if ($staff->profile_image && file_exists(public_path($staff->profile_image))) {
            unlink(public_path($staff->profile_image));
        }

        $staff->delete();

        return redirect()->route('school-admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    public function bulkImport()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.staff.bulk-import', compact('schools'));
    }

    public function processBulkImport(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls', 'max:5120'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'csv') {
                $data = array_map('str_getcsv', file($file->getRealPath()));
            } else {
                return redirect()->back()->with('error', 'Excel import coming soon. Please use CSV for now.');
            }

            if (empty($data)) {
                return redirect()->back()->with('error', 'The CSV file is empty.');
            }

            $headers = array_map('trim', array_map('strtolower', array_shift($data)));
            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                if (count($row) < count($headers)) {
                    $errors[] = 'Row '.($index + 2).': Insufficient columns.';

                    continue;
                }

                $rowData = array_combine($headers, array_map('trim', $row));

                // Normalize keys (handle variations)
                $normalizeKey = function ($key, $variations) use ($rowData) {
                    foreach ($variations as $variation) {
                        if (isset($rowData[$variation])) {
                            return $rowData[$variation];
                        }
                    }

                    return null;
                };

                try {
                    $firstName = trim($normalizeKey('first_name', ['first_name', 'firstname', 'fname']) ?? '');
                    $lastName = trim($normalizeKey('last_name', ['last_name', 'lastname', 'lname']) ?? '');
                    $email = trim($normalizeKey('email', ['email', 'e-mail']) ?? '');
                    $employeeId = trim($normalizeKey('employee_id', ['employee_id', 'employeeid', 'emp_id', 'emp id']) ?? '');
                    $designation = trim($normalizeKey('designation', ['designation', 'design', 'position', 'post']) ?? '');

                    // Validate required fields
                    if (empty($firstName) || empty($lastName)) {
                        $errors[] = 'Row '.($index + 2).': First name and last name are required.';

                        continue;
                    }

                    if (empty($email)) {
                        $errors[] = 'Row '.($index + 2).': Email is required.';

                        continue;
                    }

                    if (empty($employeeId)) {
                        $errors[] = 'Row '.($index + 2).': Employee ID is required.';

                        continue;
                    }

                    if (empty($designation)) {
                        $errors[] = 'Row '.($index + 2).': Designation is required.';

                        continue;
                    }

                    // Check if email already exists for this role
                    if (User::where('email', $email)->where('role', 'staff')->exists()) {
                        $errors[] = 'Row '.($index + 2).': Email already exists.';

                        continue;
                    }

                    // Check if employee_id already exists for this role
                    if (User::where('employee_id', $employeeId)->where('role', 'staff')->exists()) {
                        $errors[] = 'Row '.($index + 2).': Employee ID already exists.';

                        continue;
                    }

                    User::create([
                        'role' => 'staff',
                        'school_id' => $request->school_id,
                        'name' => trim($firstName.' '.$lastName),
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => $normalizeKey('phone', ['phone', 'mobile', 'contact']) ?? null,
                        'employee_id' => $employeeId,
                        'date_of_birth' => ! empty($normalizeKey('date_of_birth', ['date_of_birth', 'dob', 'birth_date'])) ? $normalizeKey('date_of_birth', ['date_of_birth', 'dob', 'birth_date']) : null,
                        'gender' => $normalizeKey('gender', ['gender', 'sex']) ?? null,
                        'address' => $normalizeKey('address', ['address', 'addr']) ?? null,
                        'designation' => $designation,
                        'department' => $normalizeKey('department', ['department', 'dept']) ?? null,
                        'joining_date' => ! empty($normalizeKey('joining_date', ['joining_date', 'join_date', 'date_of_joining'])) ? $normalizeKey('joining_date', ['joining_date', 'join_date', 'date_of_joining']) : null,
                        'salary' => ! empty($normalizeKey('salary', ['salary', 'sal'])) ? $normalizeKey('salary', ['salary', 'sal']) : null,
                        'password' => $normalizeKey('password', ['password', 'pwd']) ?? $employeeId,
                        'is_active' => ($normalizeKey('is_active', ['is_active', 'active', 'status']) ?? '1') == '1',
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row '.($index + 2).': '.$e->getMessage();
                }
            }

            if ($imported > 0) {
                $message = "$imported staff member(s) imported successfully.";
                if (count($errors) > 0) {
                    $message .= ' '.count($errors).' row(s) failed.';
                }

                return redirect()->route('school-admin.staff.index')->with('success', $message);
            } else {
                return redirect()->back()->with('error', 'No staff members were imported. '.implode(' ', $errors));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }
}
