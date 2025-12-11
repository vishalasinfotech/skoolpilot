<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_exam_schedules_index(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.exam-schedule.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.exam-schedule.index');
    }

    public function test_can_view_create_exam_schedule_form(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.exam-schedule.create'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.exam-schedule.create');
    }

    public function test_can_create_exam_schedule(): void
    {
        $school = School::factory()->create();
        $exam = Exam::factory()->create(['school_id' => $school->id]);
        $class = AcademicClass::factory()->create(['school_id' => $school->id]);
        $section = Section::factory()->create(['school_id' => $school->id]);
        $subject = Subject::factory()->create(['school_id' => $school->id]);
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $scheduleData = [
            'school_id' => $school->id,
            'exam_id' => $exam->id,
            'academic_class_id' => $class->id,
            'section_id' => $section->id,
            'subject_id' => $subject->id,
            'exam_date' => now()->addDays(30)->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'room_number' => 'Room 101',
            'total_marks' => 100,
            'passing_marks' => 33,
            'instructions' => 'Bring calculator and pen',
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.exam-schedule.store'), $scheduleData);

        $response->assertRedirect(route('school-admin.exam-schedule.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('exam_schedules', [
            'school_id' => $school->id,
            'exam_id' => $exam->id,
            'academic_class_id' => $class->id,
            'subject_id' => $subject->id,
            'room_number' => 'Room 101',
        ]);
    }

    public function test_cannot_create_exam_schedule_with_invalid_data(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $scheduleData = [
            'school_id' => $school->id,
            'exam_id' => 99999, // Invalid exam ID
            'academic_class_id' => 99999, // Invalid class ID
            'subject_id' => 99999, // Invalid subject ID
            'exam_date' => '',
            'start_time' => '11:00',
            'end_time' => '09:00', // End before start
            'total_marks' => -10, // Invalid marks
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.exam-schedule.store'), $scheduleData);

        $response->assertSessionHasErrors(['exam_id', 'academic_class_id', 'subject_id', 'exam_date', 'end_time', 'total_marks']);
    }
}
