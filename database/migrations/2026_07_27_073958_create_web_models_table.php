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
        Schema::create('web_models', function (Blueprint $table) {
            $table->id();
            $table->string('website_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('promotion_text')->nullable();
            $table->string('support_email')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_models');
    }
};
