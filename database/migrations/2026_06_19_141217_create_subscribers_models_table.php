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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();

            $table->string('ip_address')->nullable();
            $table->text('location')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('device_model')->nullable();
            $table->string('plan')->nullable();

            // ==========================
            // Subscription Fields
            // ==========================
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();

            $table->enum('frequency', [
                'weekly',
                '2weeks',
                'monthly'
            ])->nullable();

            $table->decimal('discount', 8, 2)->default(0);

            $table->enum('status', [
                'active',
                'paused',
                'cancelled'
            ])->default('active');

            $table->timestamp('next_billing_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};