<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Subject\StoreSubjectRequest;
use App\Http\Requests\SchoolAdmin\Subject\UpdateSubjectRequest;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;

class SubjectController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Subject::class);

        return view('school-admin.subject.index');
    }

    public function create()
    {
        $this->authorize('create', Subject::class);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.subject.create', compact('schools'));
    }

    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);

        return view('school-admin.subject.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.subject.edit', compact('subject', 'schools'));
    }

    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Subject::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;
        Subject::create($data);

        return redirect()->route('school-admin.subject.index')
            ->with('success', 'Subject created successfully.');
    }

    public function update(UpdateSubjectRequest $request, Subject $subject): RedirectResponse
    {
        $this->authorize('update', $subject);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        $subject->update($data);

        return redirect()->route('school-admin.subject.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $this->authorize('delete', $subject);
        $subject->delete();

        return redirect()->route('school-admin.subject.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
