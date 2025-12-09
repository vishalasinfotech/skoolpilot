<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Teacher\StoreTeacherRequest;
use App\Http\Requests\SchoolAdmin\Teacher\UpdateTeacherRequest;
use App\Models\School;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('school-admin.teacher.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.teacher.create', compact('schools'));
    }

    public function show(User $teacher)
    {
        abort_unless($teacher->isTeacher(), 404);

        return view('school-admin.teacher.show', compact('teacher'));
    }

    public function edit(User $teacher)
    {
        abort_unless($teacher->isTeacher(), 404);

        $schools = School::where('id', auth()->user()->school_id)->where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.teacher.edit', compact('teacher', 'schools'));
    }

    public function store(StoreTeacherRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'teachers/profiles'
            );
        }
        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'teachers/docs'
            );
        }

        unset($data['password_confirmation']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['role'] = 'teacher';
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        // Set default password if not provided
        if (empty($data['password'])) {
            $data['password'] = $data['employee_id'] ?? 'password123';
        }

        User::create($data);

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function update(UpdateTeacherRequest $request, User $teacher, ImageUploadService $imageUploadService): RedirectResponse
    {
        abort_unless($teacher->isTeacher(), 404);

        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'teachers/profiles',
                $teacher->profile_image
            );
        }

        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'teachers/docs',
                $teacher->doc_image
            );
        }

        unset($data['password_confirmation']);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active', false);
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));
        $teacher->update($data);

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(User $teacher): RedirectResponse
    {
        abort_unless($teacher->isTeacher(), 404);

        if ($teacher->profile_image && file_exists(public_path($teacher->profile_image))) {
            unlink(public_path($teacher->profile_image));
        }

        if ($teacher->doc_image && file_exists(public_path($teacher->doc_image))) {
            unlink(public_path($teacher->doc_image));
        }

        $teacher->delete();

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    public function bulkImport()
    {
        $schools = School::where('id', auth()->user()->school_id)->where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.teacher.bulk-import', compact('schools'));
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

                    // Check if email already exists for this role
                    if (User::where('email', $email)->where('role', 'teacher')->exists()) {
                        $errors[] = 'Row '.($index + 2).': Email already exists.';

                        continue;
                    }

                    // Check if employee_id already exists for this role
                    if (User::where('employee_id', $employeeId)->where('role', 'teacher')->exists()) {
                        $errors[] = 'Row '.($index + 2).': Employee ID already exists.';

                        continue;
                    }

                    User::create([
                        'role' => 'teacher',
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
                        'qualification' => $normalizeKey('qualification', ['qualification', 'qual']) ?? null,
                        'specialization' => $normalizeKey('specialization', ['specialization', 'speciality', 'subject']) ?? null,
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
                $message = "$imported teacher(s) imported successfully.";
                if (count($errors) > 0) {
                    $message .= ' '.count($errors).' row(s) failed.';
                }

                return redirect()->route('school-admin.teacher.index')->with('success', $message);
            } else {
                return redirect()->back()->with('error', 'No teachers were imported. '.implode(' ', $errors));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }
}
