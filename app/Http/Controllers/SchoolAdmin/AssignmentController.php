<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Assignment\StoreAssignmentRequest;
use App\Http\Requests\SchoolAdmin\Assignment\UpdateAssignmentRequest;
use App\Models\AcademicClass;
use App\Models\Assignment;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Services\ImageUploadService;

class AssignmentController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function teacherIndex(): View
    {
        return view('school-admin.assignment.teacher-index');
    }

    public function create(): View
    {
        $classes = AcademicClass::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        $subjects = Subject::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        $sections = Section::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        return view('school-admin.assignment.create', compact('classes', 'subjects', 'sections'));
    }

    public function store(StoreAssignmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->imageUploadService->uploadImage(
                $request->file('attachment'),
                'assignments'
            );
        }

        $data['teacher_id'] = auth()->id();
        $data['school_id'] = auth()->user()->school_id;

        Assignment::create($data);

        return redirect()
            ->route('teacher.assignment.index')
            ->with('success', 'Assignment created successfully!');
    }

    public function show(Assignment $assignment): View
    {
        abort_unless($assignment->teacher_id === auth()->id(), 403);

        return view('school-admin.assignment.show', [
            'assignment' => $assignment->load(['teacher', 'academicClass', 'subject', 'section']),
        ]);
    }

    public function edit(Assignment $assignment): View
    {
        abort_unless($assignment->teacher_id === auth()->id(), 403);

        $classes = AcademicClass::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        $subjects = Subject::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        $sections = Section::where('deleted_at', null)
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        return view('school-admin.assignment.edit', compact('assignment', 'classes', 'subjects', 'sections'));
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment): RedirectResponse
    {
        abort_unless($assignment->teacher_id === auth()->id(), 403);

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->imageUploadService->uploadImage(
                $request->file('attachment'),
                'assignments',
                $assignment->attachment
            );
        }

        $assignment->update($data);

        return redirect()
            ->route('teacher.assignment.index')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        abort_unless($assignment->teacher_id === auth()->id(), 403);

        // Delete attachment if exists
        if ($assignment->attachment && Storage::disk('public')->exists($assignment->attachment)) {
            Storage::disk('public')->delete($assignment->attachment);
        }

        $assignment->delete();

        return redirect()
            ->route('teacher.assignment.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}
