<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SubscriptionPlan\StoreSubscriptionPlanRequest;
use App\Http\Requests\SuperAdmin\SubscriptionPlan\UpdateSubscriptionPlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(static function ($request, $next) {
            Gate::authorize('access-super-admin');

            return $next($request);
        })->except(['plans']);
    }

    public function index()
    {
        return view('super-admin.subscription-plan.index');
    }

    public function create()
    {
        return view('super-admin.subscription-plan.create');
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('super-admin.subscription-plan.show', compact('subscriptionPlan'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('super-admin.subscription-plan.edit', compact('subscriptionPlan'));
    }

    public function store(StoreSubscriptionPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        // Handle features array
        if ($request->has('features') && is_array($request->features)) {
            $data['features'] = array_filter($request->features);
        }

        SubscriptionPlan::create($data);

        return redirect()->route('super-admin.subscription-plan.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        // Handle features array
        if ($request->has('features') && is_array($request->features)) {
            $data['features'] = array_filter($request->features);
        }

        $subscriptionPlan->update($data);

        return redirect()->route('super-admin.subscription-plan.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $subscriptionPlan->delete();

        return redirect()->route('super-admin.subscription-plan.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    public function plans()
    {
        Gate::authorize('view-subscription-plans');

        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->paginate(10);

        return view('super-admin.subscription-plan.plans', compact('subscriptionPlans'));
    }
}
