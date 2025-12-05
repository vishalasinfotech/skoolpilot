<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Student\StoreStudentRequest;
use App\Http\Requests\SchoolAdmin\Student\UpdateStudentRequest;
use App\Models\School;
use App\Models\Student;
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
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.student.create', compact('schools'));
    }

    public function show(Student $student)
    {
        return view('school-admin.student.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.student.edit', compact('student', 'schools'));
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

        $data['is_active'] = $request->boolean('is_active', true);

        Student::create($data);

        return redirect()->route('school-admin.student.index')
            ->with('success', 'Student created successfully.');
    }

    public function update(UpdateStudentRequest $request, Student $student, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'students/profiles',
                $student->profile_image
            );
        }

        $data['is_active'] = $request->boolean('is_active', false);
        $student->update($data);

        return redirect()->route('school-admin.student.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        if ($student->profile_image && file_exists(public_path($student->profile_image))) {
            unlink(public_path($student->profile_image));
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

            $headers = array_shift($data);
            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if (count($row) < count($headers)) {
                    continue;
                }

                $rowData = array_combine($headers, $row);

                try {
                    Student::create([
                        'school_id' => $request->school_id,
                        'first_name' => $rowData['first_name'] ?? '',
                        'last_name' => $rowData['last_name'] ?? '',
                        'email' => $rowData['email'] ?? null,
                        'phone' => $rowData['phone'] ?? null,
                        'parent_phone' => $rowData['parent_phone'] ?? null,
                        'admission_number' => $rowData['admission_number'] ?? '',
                        'date_of_birth' => ! empty($rowData['date_of_birth']) ? $rowData['date_of_birth'] : null,
                        'gender' => $rowData['gender'] ?? null,
                        'address' => $rowData['address'] ?? null,
                        'class' => $rowData['class'] ?? null,
                        'section' => $rowData['section'] ?? null,
                        'roll_number' => $rowData['roll_number'] ?? null,
                        'admission_date' => ! empty($rowData['admission_date']) ? $rowData['admission_date'] : null,
                        'parent_name' => $rowData['parent_name'] ?? null,
                        'parent_email' => $rowData['parent_email'] ?? null,
                        'blood_group' => $rowData['blood_group'] ?? null,
                        'is_active' => ($rowData['is_active'] ?? '1') == '1',
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
