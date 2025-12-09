<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Student\StoreStudentRequest;
use App\Http\Requests\SchoolAdmin\Student\UpdateStudentRequest;
use App\Models\AcademicClass;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('school-admin.student.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $classes = AcademicClass::where('deleted_at', null)->where('is_active', true)->pluck('name', 'id');
        $sections = Section::where('deleted_at', null)->where('is_active', true)->pluck('name', 'id');

        return view('school-admin.student.create', compact('schools', 'classes', 'sections'));
    }

    public function show(User $student)
    {
        abort_unless($student->isStudent(), 404);

        return view('school-admin.student.show', compact('student'));
    }

    public function edit(User $student)
    {
        abort_unless($student->isStudent(), 404);

        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $classes = AcademicClass::where('deleted_at', null)->where('school_id', $student->school_id)->where('is_active', true)->pluck('name', 'id');
        $sections = Section::where('deleted_at', null)->where('school_id', $student->school_id)->where('is_active', true)->pluck('name', 'id');

        return view('school-admin.student.edit', compact('student', 'schools', 'classes', 'sections'));
    }

    public function store(StoreStudentRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'students/profiles'
            );
        }
        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'students/docs'
            );
        }

        unset($data['password_confirmation']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['role'] = 'student';
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        // Set default password if not provided
        if (empty($data['password'])) {
            $data['password'] = $data['admission_number'] ?? 'password123';
        }

        User::create($data);

        return redirect()->route('school-admin.student.index')
            ->with('success', 'Student created successfully.');
    }

    public function update(UpdateStudentRequest $request, User $student, ImageUploadService $imageUploadService): RedirectResponse
    {
        abort_unless($student->isStudent(), 404);

        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'students/profiles',
                $student->profile_image
            );
        }
        if ($request->hasFile('doc_image')) {
            $data['doc_image'] = $imageUploadService->uploadImage(
                $request->file('doc_image'),
                'students/docs',
                $student->doc_image
            );
        }

        unset($data['password_confirmation']);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active', false);
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));
        $student->update($data);

        return redirect()->route('school-admin.student.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        abort_unless($student->isStudent(), 404);

        if ($student->profile_image && file_exists(public_path($student->profile_image))) {
            unlink(public_path($student->profile_image));
        }

        if ($student->doc_image && file_exists(public_path($student->doc_image))) {
            unlink(public_path($student->doc_image));
        }

        $student->delete();

        return redirect()->route('school-admin.student.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function bulkImport()
    {
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.student.bulk-import', compact('schools'));
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
                    $admissionNumber = trim($normalizeKey('admission_number', ['admission_number', 'admission_no', 'adm_no', 'admission no']) ?? '');

                    // Validate required fields
                    if (empty($firstName) || empty($lastName)) {
                        $errors[] = 'Row '.($index + 2).': First name and last name are required.';

                        continue;
                    }

                    if (empty($admissionNumber)) {
                        $errors[] = 'Row '.($index + 2).': Admission number is required.';

                        continue;
                    }

                    // Check if admission_number already exists for this role
                    if (User::where('admission_number', $admissionNumber)->where('role', 'student')->exists()) {
                        $errors[] = 'Row '.($index + 2).': Admission number already exists.';

                        continue;
                    }

                    // Handle class_id - can be provided as ID or class name
                    $classId = null;
                    $className = $normalizeKey('class', ['class', 'class_name', 'class name', 'academic_class']);
                    if (! empty($className)) {
                        $academicClass = AcademicClass::where('school_id', $request->school_id)
                            ->where('name', $className)
                            ->where('is_active', true)
                            ->first();
                        if ($academicClass) {
                            $classId = $academicClass->id;
                        }
                    }
                    // Also check if class_id is provided directly
                    $classIdDirect = $normalizeKey('class_id', ['class_id', 'classid', 'class id']);
                    if (! empty($classIdDirect) && is_numeric($classIdDirect)) {
                        $classId = $classIdDirect;
                    }

                    // Handle section_id - can be provided as ID or section name
                    $sectionId = null;
                    $sectionName = $normalizeKey('section', ['section', 'section_name', 'section name']);
                    if (! empty($sectionName)) {
                        $section = Section::where('school_id', $request->school_id)
                            ->where('name', $sectionName)
                            ->where('is_active', true)
                            ->first();
                        if ($section) {
                            $sectionId = $section->id;
                        }
                    }
                    // Also check if section_id is provided directly
                    $sectionIdDirect = $normalizeKey('section_id', ['section_id', 'sectionid', 'section id']);
                    if (! empty($sectionIdDirect) && is_numeric($sectionIdDirect)) {
                        $sectionId = $sectionIdDirect;
                    }

                    User::create([
                        'role' => 'student',
                        'school_id' => $request->school_id,
                        'name' => trim($firstName.' '.$lastName),
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $normalizeKey('email', ['email', 'e-mail']) ?? null,
                        'phone' => $normalizeKey('phone', ['phone', 'mobile', 'contact']) ?? null,
                        'parent_phone' => $normalizeKey('parent_phone', ['parent_phone', 'parent phone', 'guardian_phone', 'guardian phone']) ?? null,
                        'admission_number' => $admissionNumber,
                        'date_of_birth' => ! empty($normalizeKey('date_of_birth', ['date_of_birth', 'dob', 'birth_date'])) ? $normalizeKey('date_of_birth', ['date_of_birth', 'dob', 'birth_date']) : null,
                        'gender' => $normalizeKey('gender', ['gender', 'sex']) ?? null,
                        'address' => $normalizeKey('address', ['address', 'addr']) ?? null,
                        'class' => $className ?? null,
                        'section' => $sectionName ?? null,
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        'roll_number' => $normalizeKey('roll_number', ['roll_number', 'roll_no', 'roll no', 'roll']) ?? null,
                        'admission_date' => ! empty($normalizeKey('admission_date', ['admission_date', 'admission date', 'adm_date'])) ? $normalizeKey('admission_date', ['admission_date', 'admission date', 'adm_date']) : null,
                        'parent_name' => $normalizeKey('parent_name', ['parent_name', 'parent name', 'guardian_name', 'guardian name']) ?? null,
                        'parent_email' => $normalizeKey('parent_email', ['parent_email', 'parent email', 'guardian_email', 'guardian email']) ?? null,
                        'blood_group' => $normalizeKey('blood_group', ['blood_group', 'blood group', 'bloodgroup', 'bg']) ?? null,
                        'password' => $normalizeKey('password', ['password', 'pwd']) ?? $admissionNumber,
                        'is_active' => ($normalizeKey('is_active', ['is_active', 'active', 'status']) ?? '1') == '1',
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row '.($index + 2).': '.$e->getMessage();
                }
            }

            if ($imported > 0) {
                $message = "$imported student(s) imported successfully.";
                if (count($errors) > 0) {
                    $message .= ' '.count($errors).' row(s) failed.';
                }

                return redirect()->route('school-admin.student.index')->with('success', $message);
            } else {
                return redirect()->back()->with('error', 'No students were imported. '.implode(' ', $errors));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }
}
