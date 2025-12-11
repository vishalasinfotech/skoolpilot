<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\School;
use Illuminate\Database\Seeder;

class AcademicSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            // Create current session
            AcademicSession::factory()->create([
                'school_id' => $school->id,
                'name' => '2024-2025',
                'start_date' => '2024-04-01',
                'end_date' => '2025-03-31',
                'is_current' => true,
                'is_active' => true,
            ]);

            // Create past sessions
            AcademicSession::factory()->count(2)->create([
                'school_id' => $school->id,
                'is_current' => false,
            ]);

            // Create future session
            AcademicSession::factory()->create([
                'school_id' => $school->id,
                'name' => '2025-2026',
                'start_date' => '2025-04-01',
                'end_date' => '2026-03-31',
                'is_current' => false,
                'is_active' => true,
            ]);
        }
    }
}
