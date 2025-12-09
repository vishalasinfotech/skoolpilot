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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
<<<<<<< HEAD
            $table->enum('type', ['monthly', 'quarterly', 'yearly', 'lifetime'])->default('monthly');
            $table->enum('tier', ['basic', 'standard', 'premium']);
            $table->enum('plan_status', ['free', 'paid'])->default('paid');
=======
            $table->string('type');
            $table->string('tier');
>>>>>>> 003465f2ce57f7f463f191ac35fdf6232bb3ef88
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->integer('trial_days')->default(15);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
