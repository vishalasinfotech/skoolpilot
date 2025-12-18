<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Module names from sidebar (collapsed & expanded routes)
        $modules = [
            'school',
            'subscription_plan',
            'transaction_history',
            'setting_general',
            'setting_payment',
            'role',
            'report',
            'revenue_report',
            'schools_report',
            'transactions_report',
            'feedback',
            'language',
            'teacher',
            'student',
            'staff',
            'promotion',
            'academic_class',
            'section',
            'subject',
            'academic_session',
            'attendance',
            'exam',
            'exam_schedule',
            'result',
            'event',
            'holiday',
            'calendar',
            'fee_type',
            'fee_invoice',
            'fee_payment',
            'library',
            'issued_books',
            'transportation',
            'current_plan',
            'notification',
            'students_report',
            'teachers_report',
            'staff_report',
            'fees_report',
            'exam_results_report',
            'library_report',
            'profile',
            'classroom',
            'assignments',
            'apply_for_leave',
            'class_students',
            'add_student_complaint',
            'student_exam_schedule_results',
            'my_children',
            'view_student_complaints',
        ];

        $operations = [
            'create',
            'edit',
            'delete',
            'view',
            'view_any', // For general listing/browsing
        ];

        $permissions = [];

        foreach ($modules as $module) {
            foreach ($operations as $operation) {
                $permissions[] = "{$operation}_{$module}";
            }
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
