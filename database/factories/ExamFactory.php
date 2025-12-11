<?php

namespace Database\Factories;

use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');

        return [
            'school_id' => School::factory(),
            'academic_session_id' => AcademicSession::factory(),
            'name' => fake()->randomElement(['Mid-Term Exam', 'Final Exam', 'Unit Test', 'Quarterly Exam', 'Annual Exam']),
            'exam_type' => fake()->randomElement(['regular', 'mid_term', 'final', 'unit_test', 'quiz']),
            'description' => fake()->optional()->sentence(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
        ];
    }
}
