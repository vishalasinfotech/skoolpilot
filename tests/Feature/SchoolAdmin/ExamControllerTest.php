<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\AcademicSession;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_exams_index(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.exam.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.exam.index');
    }

    public function test_can_view_create_exam_form(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.exam.create'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.exam.create');
    }

    public function test_can_create_exam(): void
    {
        $school = School::factory()->create();
        $session = AcademicSession::factory()->create([
            'school_id' => $school->id,
            'is_current' => true,
        ]);
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $examData = [
            'school_id' => $school->id,
            'academic_session_id' => $session->id,
            'name' => 'Mid-Term Exam',
            'exam_type' => 'mid_term',
            'start_date' => now()->addDays(30)->format('Y-m-d'),
            'end_date' => now()->addDays(45)->format('Y-m-d'),
            'description' => 'Mid-term examination',
            'is_active' => true,
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.exam.store'), $examData);

        $response->assertRedirect(route('school-admin.exam.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('exams', [
            'school_id' => $school->id,
            'name' => 'Mid-Term Exam',
            'exam_type' => 'mid_term',
        ]);
    }

    public function test_cannot_create_exam_with_invalid_data(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $examData = [
            'school_id' => $school->id,
            'name' => '',
            'exam_type' => 'invalid_type',
            'start_date' => now()->addDays(45)->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'), // End before start
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.exam.store'), $examData);

        $response->assertSessionHasErrors(['name', 'exam_type', 'academic_session_id', 'end_date']);
    }
}
