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
        // Update payment_method enum to replace 'bank' with 'online'
        DB::statement("ALTER TABLE student_fee_transactions MODIFY COLUMN payment_method ENUM('cash', 'online', 'cheque') DEFAULT 'cash'");

        // Add UPI fields
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->string('upi_name')->nullable()->after('bank_reference');
            $table->string('upi_id')->nullable()->after('upi_name');
        });

        // Update existing 'bank' records to 'online'
        DB::table('student_fee_transactions')
            ->where('payment_method', 'bank')
            ->update(['payment_method' => 'online']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update payment_method enum back to include 'bank'
        DB::statement("ALTER TABLE student_fee_transactions MODIFY COLUMN payment_method ENUM('cash', 'bank', 'cheque') DEFAULT 'cash'");

        // Update existing 'online' records back to 'bank'
        DB::table('student_fee_transactions')
            ->where('payment_method', 'online')
            ->update(['payment_method' => 'bank']);

        // Remove UPI fields
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->dropColumn(['upi_name', 'upi_id']);
        });
    }
};
