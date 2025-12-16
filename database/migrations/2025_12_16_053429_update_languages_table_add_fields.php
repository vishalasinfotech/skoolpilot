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
        Schema::table('languages', function (Blueprint $table) {
            if (! Schema::hasColumn('languages', 'code')) {
                $table->string('code', 10)->unique()->after('id');
            }
            if (! Schema::hasColumn('languages', 'name')) {
                $table->string('name')->after('code');
            }
            if (! Schema::hasColumn('languages', 'native_name')) {
                $table->string('native_name')->nullable()->after('name');
            }
            if (! Schema::hasColumn('languages', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('native_name');
            }
            if (! Schema::hasColumn('languages', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('is_active');
            }
            if (! Schema::hasColumn('languages', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_default');
            }
            if (! Schema::hasColumn('languages', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn(['code', 'name', 'native_name', 'is_active', 'is_default', 'sort_order', 'deleted_at']);
        });
    }
};
