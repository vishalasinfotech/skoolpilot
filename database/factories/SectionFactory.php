<?php

namespace Database\Factories;

use App\Models\School;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sectionNames = ['A', 'B', 'C', 'D', 'E', 'Science', 'Arts', 'Commerce'];

        return [
            'school_id' => School::factory(),
            'name' => fake()->randomElement($sectionNames),
            'description' => fake()->optional()->sentence(),
            'short_code' => fake()->optional()->randomLetter(),
            'is_active' => true,
        ];
    }
}
