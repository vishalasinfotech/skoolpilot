<?php

namespace Database\Factories;

use App\Models\AcademicClass;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicClass>
 */
class AcademicClassFactory extends Factory
{
    protected $model = AcademicClass::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classNames = ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'];

        return [
            'school_id' => School::factory(),
            'name' => fake()->randomElement($classNames),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
