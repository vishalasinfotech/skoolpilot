<?php

namespace Database\Factories;

use App\Models\School;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Mathematics', 'English', 'Science', 'Social Studies', 'History', 'Geography', 'Physics', 'Chemistry', 'Biology', 'Computer Science', 'Art', 'Music', 'Physical Education'];

        return [
            'school_id' => School::factory(),
            'name' => fake()->randomElement($subjects),
            'code' => fake()->optional()->regexify('[A-Z]{3,4}'),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
