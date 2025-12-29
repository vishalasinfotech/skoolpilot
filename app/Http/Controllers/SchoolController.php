<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\RegisterSchoolRequest;
use App\Models\School;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    public function create(): View
    {
        $subscriptionPlans = SubscriptionPlan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('school.register', compact('subscriptionPlans'));
    }

    public function store(RegisterSchoolRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $imageUploadService): void {
            $schoolData = [
                'name' => $data['school_name'],
                'email' => $data['school_email'],
                'phone' => $data['school_phone'] ?? '',
                'address' => $data['school_address'] ?? '',
                'logo' => 'assets/images/logo-sm.png',
                'theme_color' => $data['theme_color'],
                'status' => true,
                'subscription_plan_id' => $data['subscription_plan_id'] ?? null,
                'trial_ends_at' => null,
            ];

            if ($request->hasFile('logo')) {
                $schoolData['logo'] = $imageUploadService->uploadImage(
                    $request->file('logo'),
                    'uploads/schools/logos'
                );
            }

            if ($schoolData['subscription_plan_id'] !== null) {
                $plan = SubscriptionPlan::query()->find($schoolData['subscription_plan_id']);
                if ($plan && $plan->trial_days) {
                    $schoolData['trial_ends_at'] = now()->addDays($plan->trial_days);
                }
            }

            $school = School::create($schoolData);

            User::create([
                'name' => $data['admin_name'],
                'email' => $data['admin_email'],
                'password' => Hash::make($data['password']),
                'role' => 'school-admin',
                'school_id' => $school->id,
                'is_active' => true,
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'School registration successful. You can now sign in.');
    }
}
