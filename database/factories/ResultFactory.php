<?php

namespace Database\Factories;

use App\Models\AcademicClass;
use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Result;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    protected $model = Result::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalMarks = fake()->randomElement([50, 100, 75, 80]);
        $obtainedMarks = fake()->numberBetween(0, $totalMarks);
        $percentage = ($obtainedMarks / $totalMarks) * 100;

        $grade = match (true) {
            $percentage >= 90 => 'A+',
            $percentage >= 80 => 'A',
            $percentage >= 70 => 'B+',
            $percentage >= 60 => 'B',
            $percentage >= 50 => 'C+',
            $percentage >= 40 => 'C',
            $percentage >= 33 => 'D',
            default => 'F',
        };

        $status = $percentage >= 33 ? 'pass' : 'fail';

        return [
            'school_id' => School::factory(),
            'academic_session_id' => AcademicSession::factory(),
            'exam_id' => Exam::factory(),
            'exam_schedule_id' => ExamSchedule::factory(),
            'student_id' => User::factory()->state(['role' => 'student']),
            'subject_id' => Subject::factory(),
            'academic_class_id' => AcademicClass::factory(),
            'section_id' => Section::factory(),
            'obtained_marks' => $obtainedMarks,
            'total_marks' => $totalMarks,
            'grade' => $grade,
            'percentage' => round($percentage, 2),
            'status' => $status,
            'remarks' => fake()->optional()->sentence(),
            'entered_by' => User::factory()->state(['role' => 'teacher']),
        ];
    }
}
