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
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('vehicle_number');
            $table->string('vehicle_type'); // bus, van, car, etc.
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('driver_license_number')->nullable();
            $table->integer('capacity')->default(0);
            $table->string('route_name')->nullable();
            $table->text('route_description')->nullable();
            $table->decimal('fare_amount', 10, 2)->nullable();
            $table->date('registration_date')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('transportations');
    }
};
