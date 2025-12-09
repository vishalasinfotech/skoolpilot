<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role field - static roles: teacher, staff, student
            $table->string('role')->nullable()->after('email');
            $table->string('first_name')->nullable()->after('role');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('last_name');
            $table->string('parent_phone')->nullable()->after('phone'); // Student specific
            $table->string('employee_id')->nullable()->after('parent_phone'); // Teacher/Staff
            $table->string('admission_number')->nullable()->after('employee_id'); // Student
            $table->date('date_of_birth')->nullable()->after('admission_number');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('gender');
            $table->string('blood_group')->nullable()->after('address'); // Student specific

            // Teacher specific fields
            $table->string('qualification')->nullable()->after('blood_group');
            $table->string('specialization')->nullable()->after('qualification');

            // Staff specific fields
            $table->string('designation')->nullable()->after('specialization');
            $table->string('department')->nullable()->after('designation');

            // Student specific fields
            $table->string('class')->nullable()->after('department'); // Legacy field
            $table->string('section')->nullable()->after('class'); // Legacy field
            $table->foreignId('class_id')->nullable()->after('section')->constrained('academic_classes')->onDelete('set null');
            $table->foreignId('section_id')->nullable()->after('class_id')->constrained('sections')->onDelete('set null');
            $table->string('roll_number')->nullable()->after('section_id');
            $table->date('admission_date')->nullable()->after('roll_number');
            $table->string('parent_name')->nullable()->after('admission_date');
            $table->string('parent_email')->nullable()->after('parent_name');

            // Employment/Joining information
            $table->date('joining_date')->nullable()->after('parent_email'); // Teacher/Staff
            $table->decimal('salary', 10, 2)->nullable()->after('joining_date'); // Teacher/Staff

            // Media fields
            $table->string('profile_image')->nullable()->after('salary');
            $table->string('doc_type')->nullable()->after('profile_image');
            $table->string('doc_image')->nullable()->after('doc_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['class_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn([
                'role',
                'school_id',
                'first_name',
                'last_name',
                'phone',
                'parent_phone',
                'employee_id',
                'admission_number',
                'date_of_birth',
                'gender',
                'address',
                'blood_group',
                'qualification',
                'specialization',
                'designation',
                'department',
                'class',
                'section',
                'class_id',
                'section_id',
                'roll_number',
                'admission_date',
                'parent_name',
                'parent_email',
                'joining_date',
                'salary',
                'profile_image',
                'doc_type',
                'doc_image',
            ]);
        });
    }
};
