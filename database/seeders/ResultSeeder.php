<?php

namespace Database\Seeders;

use App\Models\ExamSchedule;
use App\Models\Result;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            $students = User::where('school_id', $school->id)
                ->where('role', 'student')
                ->get();

            $examSchedules = ExamSchedule::where('school_id', $school->id)
                ->with(['exam', 'subject', 'academicClass'])
                ->get();

            if ($students->isEmpty() || $examSchedules->isEmpty()) {
                continue;
            }

            foreach ($examSchedules->take(5) as $schedule) {
                foreach ($students->take(10) as $student) {
                    // Check if result already exists
                    $existingResult = Result::where('student_id', $student->id)
                        ->where('exam_schedule_id', $schedule->id)
                        ->first();

                    if ($existingResult) {
                        continue;
                    }

                    $totalMarks = $schedule->total_marks;
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

                    Result::factory()->create([
                        'school_id' => $school->id,
                        'academic_session_id' => $schedule->exam->academic_session_id,
                        'exam_id' => $schedule->exam_id,
                        'exam_schedule_id' => $schedule->id,
                        'student_id' => $student->id,
                        'subject_id' => $schedule->subject_id,
                        'academic_class_id' => $schedule->academic_class_id,
                        'section_id' => $schedule->section_id ?? $student->section_id,
                        'total_marks' => $totalMarks,
                        'obtained_marks' => $obtainedMarks,
                        'percentage' => round($percentage, 2),
                        'grade' => $grade,
                        'status' => $percentage >= 33 ? 'pass' : 'fail',
                    ]);
                }
            }
        }
    }
}
