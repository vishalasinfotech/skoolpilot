<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->decimal('offer_price', 10, 2)->nullable()->after('price');
            $table->text('description')->nullable()->after('name');
            $table->enum('plan_status', ['free', 'paid'])->default('paid')->after('tier');
        });

        // Update the type enum to include 'lifetime'
        DB::statement("ALTER TABLE subscription_plans MODIFY COLUMN type ENUM('monthly', 'quarterly', 'yearly', 'lifetime') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['offer_price', 'description', 'plan_status']);
        });

        // Revert the type enum to original values
        DB::statement("ALTER TABLE subscription_plans MODIFY COLUMN type ENUM('monthly', 'quarterly', 'yearly') NOT NULL");
    }
};
