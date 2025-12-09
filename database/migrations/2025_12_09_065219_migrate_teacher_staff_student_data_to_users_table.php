<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate teachers
        $teachers = DB::table('teachers')->get();
        foreach ($teachers as $teacher) {
            $firstName = $teacher->first_name ?? '';
            $lastName = $teacher->last_name ?? '';
            DB::table('users')->insert([
                'role' => 'teacher',
                'school_id' => $teacher->school_id,
                'name' => trim($firstName.' '.$lastName) ?: $teacher->email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $teacher->email,
                'phone' => $teacher->phone,
                'employee_id' => $teacher->employee_id,
                'date_of_birth' => $teacher->date_of_birth,
                'gender' => $teacher->gender,
                'address' => $teacher->address,
                'qualification' => $teacher->qualification,
                'specialization' => $teacher->specialization,
                'joining_date' => $teacher->joining_date,
                'salary' => $teacher->salary,
                'profile_image' => $teacher->profile_image,
                'doc_type' => $teacher->doc_type,
                'doc_image' => $teacher->doc_image,
                'password' => $teacher->password,
                'is_active' => $teacher->is_active,
                'created_at' => $teacher->created_at,
                'updated_at' => $teacher->updated_at,
                'deleted_at' => $teacher->deleted_at,
            ]);
        }

        // Migrate staff
        $staff = DB::table('staff')->get();
        foreach ($staff as $staffMember) {
            $firstName = $staffMember->first_name ?? '';
            $lastName = $staffMember->last_name ?? '';
            DB::table('users')->insert([
                'role' => 'staff',
                'school_id' => $staffMember->school_id,
                'name' => trim($firstName.' '.$lastName) ?: $staffMember->email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $staffMember->email,
                'phone' => $staffMember->phone,
                'employee_id' => $staffMember->employee_id,
                'date_of_birth' => $staffMember->date_of_birth,
                'gender' => $staffMember->gender,
                'address' => $staffMember->address,
                'designation' => $staffMember->designation,
                'department' => $staffMember->department,
                'joining_date' => $staffMember->joining_date,
                'salary' => $staffMember->salary,
                'profile_image' => $staffMember->profile_image,
                'doc_type' => $staffMember->doc_type,
                'doc_image' => $staffMember->doc_image,
                'password' => $staffMember->password,
                'is_active' => $staffMember->is_active,
                'created_at' => $staffMember->created_at,
                'updated_at' => $staffMember->updated_at,
                'deleted_at' => $staffMember->deleted_at,
            ]);
        }

        // Migrate students
        $students = DB::table('students')->get();
        foreach ($students as $student) {
            $firstName = $student->first_name ?? '';
            $lastName = $student->last_name ?? '';
            DB::table('users')->insert([
                'role' => 'student',
                'school_id' => $student->school_id,
                'name' => trim($firstName.' '.$lastName) ?: ($student->email ?? 'Student'),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $student->email,
                'phone' => $student->phone,
                'parent_phone' => $student->parent_phone,
                'admission_number' => $student->admission_number,
                'date_of_birth' => $student->date_of_birth,
                'gender' => $student->gender,
                'address' => $student->address,
                'class' => $student->class,
                'section' => $student->section,
                'class_id' => $student->class_id ?? null,
                'section_id' => $student->section_id ?? null,
                'roll_number' => $student->roll_number,
                'admission_date' => $student->admission_date,
                'parent_name' => $student->parent_name,
                'parent_email' => $student->parent_email,
                'blood_group' => $student->blood_group,
                'profile_image' => $student->profile_image,
                'doc_type' => $student->doc_type,
                'doc_image' => $student->doc_image,
                'password' => $student->password,
                'is_active' => $student->is_active,
                'created_at' => $student->created_at,
                'updated_at' => $student->updated_at,
                'deleted_at' => $student->deleted_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove migrated data (users with roles teacher, staff, student)
        DB::table('users')->whereIn('role', ['teacher', 'staff', 'student'])->delete();
    }
};
