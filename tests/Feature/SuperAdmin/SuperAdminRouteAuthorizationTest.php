<?php

namespace Tests\Feature\SuperAdmin;

use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminRouteAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_super_admin_cannot_access_super_admin_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $routes = [
            'super-admin.school.index',
            'super-admin.subscription-plan.index',
            'super-admin.setting.general',
            'super-admin.setting.payment',
            'super-admin.language.index',
            'super-admin.feedback.index',
            'reports.super-admin.revenue',
            'reports.super-admin.schools',
            'reports.super-admin.transactions',
            'payment.transaction-history',
        ];

        foreach ($routes as $routeName) {
            $this->actingAs($user)->get(route($routeName))->assertStatus(403);
        }
    }

    public function test_super_admin_can_access_super_admin_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $routes = [
            'super-admin.school.index',
            'super-admin.subscription-plan.index',
            'super-admin.setting.general',
            'super-admin.setting.payment',
            'super-admin.language.index',
            'super-admin.feedback.index',
            'reports.super-admin.revenue',
            'reports.super-admin.schools',
            'reports.super-admin.transactions',
        ];

        foreach ($routes as $routeName) {
            $this->actingAs($user)->get(route($routeName))->assertStatus(200);
        }
    }

    public function test_only_school_admin_can_view_subscription_plans_page(): void
    {
        SubscriptionPlan::factory()->create([
            'is_active' => true,
        ]);

        $schoolAdmin = User::factory()->create([
            'role' => 'school_admin',
        ]);

        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $this->actingAs($schoolAdmin)
            ->get(route('subscription-plan.plans'))
            ->assertStatus(200);

        $this->actingAs($teacher)
            ->get(route('subscription-plan.plans'))
            ->assertStatus(403);
    }
}
