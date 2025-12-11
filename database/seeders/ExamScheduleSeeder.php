<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\School;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ExamScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            $exams = Exam::where('school_id', $school->id)->get();
            $classes = AcademicClass::where('school_id', $school->id)->get();
            $sections = Section::where('school_id', $school->id)->get();
            $subjects = Subject::where('school_id', $school->id)->get();

            if ($exams->isEmpty() || $classes->isEmpty() || $subjects->isEmpty()) {
                continue;
            }

            foreach ($exams->take(2) as $exam) {
                foreach ($classes->take(2) as $class) {
                    foreach ($subjects->take(3) as $subject) {
                        ExamSchedule::factory()->create([
                            'school_id' => $school->id,
                            'exam_id' => $exam->id,
                            'academic_class_id' => $class->id,
                            'section_id' => $sections->random()->id ?? null,
                            'subject_id' => $subject->id,
                            'exam_date' => $exam->start_date->addDays(rand(0, 10)),
                            'start_time' => '09:00:00',
                            'end_time' => '11:00:00',
                        ]);
                    }
                }
            }
        }
    }
}
