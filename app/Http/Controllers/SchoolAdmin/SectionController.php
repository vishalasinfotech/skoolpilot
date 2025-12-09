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
        return view('school-admin.section.index');
    }

    public function create()
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.section.create', compact('schools'));
    }

    public function show(Section $section)
    {
        return view('school-admin.section.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.section.edit', compact('section', 'schools'));
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Section::create($data);

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section created successfully.');
    }

    public function update(UpdateSectionRequest $request, Section $section): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $section->update($data);

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return redirect()->route('school-admin.section.index')
            ->with('success', 'Section deleted successfully.');
    }
}
