<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_results_index(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.result.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.result.index');
    }

    public function test_can_view_create_result_form(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.result.create'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.result.create');
    }

    public function test_can_create_result_with_auto_calculation(): void
    {
        $school = School::factory()->create();
        $session = AcademicSession::factory()->create(['school_id' => $school->id]);
        $exam = Exam::factory()->create(['school_id' => $school->id, 'academic_session_id' => $session->id]);
        $class = AcademicClass::factory()->create(['school_id' => $school->id]);
        $section = Section::factory()->create(['school_id' => $school->id]);
        $subject = Subject::factory()->create(['school_id' => $school->id]);
        $schedule = ExamSchedule::factory()->create([
            'school_id' => $school->id,
            'exam_id' => $exam->id,
            'academic_class_id' => $class->id,
            'section_id' => $section->id,
            'subject_id' => $subject->id,
            'total_marks' => 100,
        ]);
        $student = User::factory()->create([
            'role' => 'student',
            'school_id' => $school->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school->id,
        ]);
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $resultData = [
            'school_id' => $school->id,
            'academic_session_id' => $session->id,
            'exam_id' => $exam->id,
            'exam_schedule_id' => $schedule->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'academic_class_id' => $class->id,
            'section_id' => $section->id,
            'obtained_marks' => 85,
            'total_marks' => 100,
            'status' => 'pass',
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.result.store'), $resultData);

        $response->assertRedirect(route('school-admin.result.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('results', [
            'student_id' => $student->id,
            'exam_schedule_id' => $schedule->id,
            'obtained_marks' => 85,
            'total_marks' => 100,
            'percentage' => 85.00,
            'grade' => 'A',
            'status' => 'pass',
            'entered_by' => $user->id,
        ]);
    }

    public function test_result_auto_calculates_percentage_and_grade(): void
    {
        $school = School::factory()->create();
        $session = AcademicSession::factory()->create(['school_id' => $school->id]);
        $exam = Exam::factory()->create(['school_id' => $school->id, 'academic_session_id' => $session->id]);
        $class = AcademicClass::factory()->create(['school_id' => $school->id]);
        $section = Section::factory()->create(['school_id' => $school->id]);
        $subject = Subject::factory()->create(['school_id' => $school->id]);
        $schedule = ExamSchedule::factory()->create([
            'school_id' => $school->id,
            'exam_id' => $exam->id,
            'academic_class_id' => $class->id,
            'subject_id' => $subject->id,
            'total_marks' => 100,
        ]);
        $student = User::factory()->create([
            'role' => 'student',
            'school_id' => $school->id,
        ]);
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        // Test with 95 marks (should get A+)
        $resultData = [
            'school_id' => $school->id,
            'academic_session_id' => $session->id,
            'exam_id' => $exam->id,
            'exam_schedule_id' => $schedule->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'academic_class_id' => $class->id,
            'section_id' => $section->id,
            'obtained_marks' => 95,
            'total_marks' => 100,
            'status' => 'pass',
        ];

        $this->actingAs($user)
            ->post(route('school-admin.result.store'), $resultData);

        $this->assertDatabaseHas('results', [
            'obtained_marks' => 95,
            'percentage' => 95.00,
            'grade' => 'A+',
        ]);
    }

    public function test_cannot_create_result_with_invalid_data(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $resultData = [
            'school_id' => $school->id,
            'student_id' => 99999, // Invalid student
            'exam_id' => 99999, // Invalid exam
            'obtained_marks' => -10, // Invalid marks
            'total_marks' => 0, // Invalid total
        ];

        $response = $this->actingAs($user)
            ->post(route('school-admin.result.store'), $resultData);

        $response->assertSessionHasErrors(['student_id', 'exam_id', 'academic_session_id', 'exam_schedule_id', 'subject_id', 'academic_class_id', 'obtained_marks', 'total_marks', 'status']);
    }
}
