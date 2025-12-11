<?php

namespace Database\Factories;

use App\Models\AcademicSession;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicSession>
 */
class AcademicSessionFactory extends Factory
{
    protected $model = AcademicSession::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2025);
        $endYear = $startYear + 1;
        $startDate = fake()->dateTimeBetween("{$startYear}-04-01", "{$startYear}-06-30");
        $endDate = fake()->dateTimeBetween("{$endYear}-03-01", "{$endYear}-03-31");

        return [
            'school_id' => School::factory(),
            'name' => "{$startYear}-{$endYear}",
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => false,
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the session is current.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_current' => true,
        ]);
    }
}
