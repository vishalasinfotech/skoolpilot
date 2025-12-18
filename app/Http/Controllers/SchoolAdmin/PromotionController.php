<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Promotion\PromoteStudentsRequest;
use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(): View
    {
        $schoolId = auth()->user()->school_id;

        $sessions = AcademicSession::query()
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->pluck('name', 'id');

        $currentSessionId = AcademicSession::query()
            ->where('school_id', $schoolId)
            ->where('is_current', true)
            ->where('is_active', true)
            ->value('id');

        $classes = AcademicClass::query()
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $sections = Section::query()
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('school-admin.promotions.index', compact('sessions', 'currentSessionId', 'classes', 'sections'));
    }

    public function store(PromoteStudentsRequest $request): RedirectResponse
    {
        $schoolId = auth()->user()->school_id;
        $data = $request->validated();

        $toSessionId = $data['to_academic_session_id'];

        $toClass = AcademicClass::query()
            ->where('school_id', $schoolId)
            ->where('is_active', true)
            ->findOrFail($data['to_class_id']);

        $toSection = null;
        if ($request->filled('to_section_id')) {
            $toSection = Section::query()
                ->where('school_id', $schoolId)
                ->where('is_active', true)
                ->findOrFail($data['to_section_id']);
        }

        $query = User::query()
            ->students()
            ->where('school_id', $schoolId)
            ->where('academic_session_id', $data['from_academic_session_id'])
            ->where('class_id', $data['from_class_id']);

        if (! empty($data['from_section_id'])) {
            $query->where('section_id', $data['from_section_id']);
        }

        if (! $request->boolean('include_inactive')) {
            $query->where('is_active', true);
        }

        $updates = [
            'academic_session_id' => $toSessionId,
            'class_id' => $toClass->id,
            'class' => $toClass->name,
        ];

        if ($toSection) {
            $updates['section_id'] = $toSection->id;
            $updates['section'] = $toSection->name;
        }

        $affected = $query->update($updates);

        if ($affected === 0) {
            return back()->with('error', 'No students found for the selected academic session/class/section.');
        }

        return redirect()
            ->route('school-admin.promotions.index')
            ->with('success', $affected.' student(s) promoted successfully.');
    }
}
