<?php

namespace Database\Factories;

use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamSchedule>
 */
class ExamScheduleFactory extends Factory
{
    protected $model = ExamSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->time('H:i');
        $endTime = date('H:i', strtotime($startTime.' +2 hours'));

        return [
            'school_id' => School::factory(),
            'exam_id' => Exam::factory(),
            'academic_class_id' => AcademicClass::factory(),
            'section_id' => Section::factory(),
            'subject_id' => Subject::factory(),
            'exam_date' => fake()->dateTimeBetween('now', '+1 month'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'room_number' => fake()->optional()->numerify('Room ###'),
            'total_marks' => fake()->randomElement([50, 100, 75, 80]),
            'passing_marks' => fake()->numberBetween(15, 35),
            'instructions' => fake()->optional()->paragraph(),
        ];
    }
}
