<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\School;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            $currentSession = AcademicSession::where('school_id', $school->id)
                ->where('is_current', true)
                ->first();

            if ($currentSession) {
                // Create different types of exams
                Exam::factory()->create([
                    'school_id' => $school->id,
                    'academic_session_id' => $currentSession->id,
                    'name' => 'Mid-Term Exam',
                    'exam_type' => 'mid_term',
                    'start_date' => now()->addDays(30),
                    'end_date' => now()->addDays(45),
                ]);

                Exam::factory()->create([
                    'school_id' => $school->id,
                    'academic_session_id' => $currentSession->id,
                    'name' => 'Final Exam',
                    'exam_type' => 'final',
                    'start_date' => now()->addDays(90),
                    'end_date' => now()->addDays(105),
                ]);

                Exam::factory()->create([
                    'school_id' => $school->id,
                    'academic_session_id' => $currentSession->id,
                    'name' => 'Unit Test 1',
                    'exam_type' => 'unit_test',
                    'start_date' => now()->addDays(10),
                    'end_date' => now()->addDays(15),
                ]);
            }
        }
    }
}
