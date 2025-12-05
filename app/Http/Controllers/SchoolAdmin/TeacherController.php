<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Teacher\StoreTeacherRequest;
use App\Http\Requests\SchoolAdmin\Teacher\UpdateTeacherRequest;
use App\Models\School;
use App\Models\Teacher;
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
        $schools = School::where('status', true)->pluck('name', 'id');

        return view('school-admin.teacher.create', compact('schools'));
    }

    public function show(Teacher $teacher)
    {
        return view('school-admin.teacher.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $schools = School::where('status', true)->pluck('name', 'id');

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

        $data['is_active'] = $request->boolean('is_active', true);

        Teacher::create($data);

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $imageUploadService->uploadImage(
                $request->file('profile_image'),
                'teachers/profiles',
                $teacher->profile_image
            );
        }

        $data['is_active'] = $request->boolean('is_active', false);
        $teacher->update($data);

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        if ($teacher->profile_image && file_exists(public_path($teacher->profile_image))) {
            unlink(public_path($teacher->profile_image));
        }

        $teacher->delete();

        return redirect()->route('school-admin.teacher.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    public function bulkImport()
    {
        $schools = School::where('status', true)->pluck('name', 'id');

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

            $headers = array_shift($data);
            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if (count($row) < count($headers)) {
                    continue;
                }

                $rowData = array_combine($headers, $row);

                try {
                    Teacher::create([
                        'school_id' => $request->school_id,
                        'first_name' => $rowData['first_name'] ?? '',
                        'last_name' => $rowData['last_name'] ?? '',
                        'email' => $rowData['email'] ?? '',
                        'phone' => $rowData['phone'] ?? null,
                        'employee_id' => $rowData['employee_id'] ?? '',
                        'date_of_birth' => ! empty($rowData['date_of_birth']) ? $rowData['date_of_birth'] : null,
                        'gender' => $rowData['gender'] ?? null,
                        'address' => $rowData['address'] ?? null,
                        'qualification' => $rowData['qualification'] ?? null,
                        'specialization' => $rowData['specialization'] ?? null,
                        'joining_date' => ! empty($rowData['joining_date']) ? $rowData['joining_date'] : null,
                        'salary' => ! empty($rowData['salary']) ? $rowData['salary'] : null,
                        'is_active' => ($rowData['is_active'] ?? '1') == '1',
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
