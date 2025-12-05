<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\School\StoreSchoolRequest;
use App\Http\Requests\SuperAdmin\School\UpdateSchoolRequest;
use App\Models\School;
use App\Models\SubscriptionPlan;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class SchoolController extends Controller
{
    public function index()
    {
        return view('super-admin.school.index');
    }

    public function create()
    {
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

        return view('super-admin.school.create', compact('subscriptionPlans'));
    }

    public function show(School $school)
    {
        return view('super-admin.school.show', compact('school'));
    }

    public function edit(School $school)
    {
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

        return view('super-admin.school.edit', compact('school', 'subscriptionPlans'));
    }

    public function store(StoreSchoolRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $imageUploadService->uploadImage(
                $request->file('logo'),
                'schools/logos'
            );
        }

        $data['status'] = $request->boolean('status', true);

        School::create($data);

        return redirect()->route('super-admin.school.index')->with('success', 'School created successfully.');
    }

    public function update(UpdateSchoolRequest $request, School $school, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $imageUploadService->uploadImage(
                $request->file('logo'),
                'schools/logos',
                $school->logo
            );
        }

        $data['status'] = $request->boolean('status', false);
        $school->update($data);

        return redirect()->route('super-admin.school.index')->with('success', 'School updated successfully.');
    }

    public function destroy(School $school): RedirectResponse
    {
        if ($school->logo && File::exists(public_path($school->logo))) {
            File::delete(public_path($school->logo));
        }

        $school->delete();

        return redirect()->route('super-admin.school.index')->with('success', 'School deleted successfully.');
    }
}
