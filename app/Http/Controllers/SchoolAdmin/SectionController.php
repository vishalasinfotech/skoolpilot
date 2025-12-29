<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Section\StoreSectionRequest;
use App\Http\Requests\SchoolAdmin\Section\UpdateSectionRequest;
use App\Models\School;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;

class SectionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Section::class);

        return view('school-admin.section.index');
    }

    public function create()
    {
        $this->authorize('create', Section::class);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.section.create', compact('schools'));
    }

    public function show(Section $section)
    {
        $this->authorize('view', $section);
    }

    public function edit(Section $section)
    {
        $this->authorize('update', $section);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.section.edit', compact('section', 'schools'));
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        $this->authorize('create', Section::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;
        Section::create($data);

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section created successfully.');
    }

    public function update(UpdateSectionRequest $request, Section $section): RedirectResponse
    {
        $this->authorize('update', $section);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $section->update($data);

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        $this->authorize('delete', $section);
        $section->delete();

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section deleted successfully.');
    }
}
