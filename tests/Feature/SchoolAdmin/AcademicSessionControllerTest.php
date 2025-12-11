<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_view_academic_sessions_index(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.academic-session.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.academic-session.index');
    }

    public function test_can_view_create_academic_session_form(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.academic-session.create'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.academic-session.create');
    }

    public function test_can_create_academic_session(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $sessionData = [
            'school_id' => $school->id,
            'name' => '2024-2025',
            'start_date' => '2024-04-01',
            'end_date' => '2025-03-31',
            'is_current' => true,
            'description' => 'Academic year 2024-2025',
            'is_active' => true,
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.academic-session.store'), $sessionData);

        $response->assertRedirect(route('school-admin.academic-session.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('academic_sessions', [
            'school_id' => $school->id,
            'name' => '2024-2025',
            'is_current' => true,
        ]);
    }

    public function test_cannot_create_academic_session_with_invalid_data(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $sessionData = [
            'school_id' => $school->id,
            'name' => '',
            'start_date' => '2025-03-31',
            'end_date' => '2024-04-01', // End date before start date
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.academic-session.store'), $sessionData);

        $response->assertSessionHasErrors(['name', 'end_date']);
    }
}
