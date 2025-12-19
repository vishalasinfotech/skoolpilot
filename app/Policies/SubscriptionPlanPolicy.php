<?php

namespace App\Policies;

use App\Models\SubscriptionPlan;
use App\Models\User;

class SubscriptionPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_subscription_plan');
    }

    public function view(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->can('view_subscription_plan');
    }

    public function create(User $user): bool
    {
        return $user->can('create_subscription_plan');
    }

    public function update(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->can('update_subscription_plan');
    }

    public function delete(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->can('delete_subscription_plan');
    }
}
