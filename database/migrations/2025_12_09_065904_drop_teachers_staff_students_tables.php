<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('teachers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This migration does not recreate the tables
        // If you need to rollback, you would need to restore from backup
    }
};
