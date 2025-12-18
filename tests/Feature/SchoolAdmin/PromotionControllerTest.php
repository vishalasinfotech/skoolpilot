<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\School;
use App\Models\Section;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createActiveSubscriptionForSchool(School $school): void
    {
        $plan = SubscriptionPlan::query()->create([
            'name' => 'Test Plan',
            'type' => 'monthly',
            'tier' => 'basic',
            'plan_status' => 'paid',
            'price' => 100,
            'offer_price' => null,
            'features' => ['test'],
            'trial_days' => 0,
            'is_active' => true,
        ]);

        Transaction::query()->create([
            'school_id' => $school->id,
            'subscription_plan_id' => $plan->id,
            'amount' => 100,
            'currency' => 'INR',
            'status' => 'completed',
            'payment_method' => 'other',
            'payment_details' => ['provider' => 'test'],
            'paid_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);
    }

    public function test_school_admin_can_view_promotions_page(): void
    {
        $school = School::factory()->create();
        $this->createActiveSubscriptionForSchool($school);

        AcademicSession::factory()->create([
            'school_id' => $school->id,
            'name' => '2024-2025',
            'is_current' => true,
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.promotions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.promotions.index');
    }

    public function test_can_promote_students_from_current_session_to_next_session(): void
    {
        $school = School::factory()->create();
        $this->createActiveSubscriptionForSchool($school);

        $currentSession = AcademicSession::factory()->create([
            'school_id' => $school->id,
            'name' => '2024-2025',
            'is_current' => true,
            'is_active' => true,
        ]);
        $nextSession = AcademicSession::factory()->create([
            'school_id' => $school->id,
            'name' => '2025-2026',
            'is_current' => false,
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $fromClass = AcademicClass::factory()->create([
            'school_id' => $school->id,
            'name' => 'Grade 1',
            'is_active' => true,
        ]);
        $toClass = AcademicClass::factory()->create([
            'school_id' => $school->id,
            'name' => 'Grade 2',
            'is_active' => true,
        ]);

        $fromSection = Section::factory()->create([
            'school_id' => $school->id,
            'name' => 'A',
            'is_active' => true,
        ]);
        $toSection = Section::factory()->create([
            'school_id' => $school->id,
            'name' => 'B',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'role' => 'student',
            'school_id' => $school->id,
            'academic_session_id' => $currentSession->id,
            'class_id' => $fromClass->id,
            'class' => $fromClass->name,
            'section_id' => $fromSection->id,
            'section' => $fromSection->name,
            'is_active' => true,
        ]);

        $payload = [
            'from_academic_session_id' => $currentSession->id,
            'to_academic_session_id' => $nextSession->id,
            'from_class_id' => $fromClass->id,
            'from_section_id' => $fromSection->id,
            'to_class_id' => $toClass->id,
            'to_section_id' => $toSection->id,
        ];

        $response = $this->actingAs($admin)->post(route('school-admin.promotions.store'), $payload);

        $response->assertRedirect(route('school-admin.promotions.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'academic_session_id' => $nextSession->id,
            'class_id' => $toClass->id,
            'section_id' => $toSection->id,
        ]);
    }
}
