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
        if (! Schema::hasColumn('users', 'academic_session_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table
                    ->foreignId('academic_session_id')
                    ->nullable()
                    ->after('school_id')
                    ->constrained('academic_sessions')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'academic_session_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['academic_session_id']);
                $table->dropColumn('academic_session_id');
            });
        }
    }
};
