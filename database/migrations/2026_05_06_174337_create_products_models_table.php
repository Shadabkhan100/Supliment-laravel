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
    Schema::create('products_models', function (Blueprint $table) {
        $table->id();

        // Basic Info
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('sku')->unique();

        // Category (if you have categories table)
        $table->foreignId('category_id')->nullable()->constrained('categories_models')->nullOnDelete();
        $table->foreignId('deal_id')->nullable()->constrained('slimza_deals')->nullOnDelete();


        // Pricing
        $table->decimal('price', 10, 2);
        $table->decimal('old_price', 10, 2)->nullable();

        // Stock
        $table->integer('stock')->default(0);

        // Product Options (like 250g, 500g)
        $table->json('weights')->nullable(); 
        // Example: ["250g","500g","1000g"]

        // Images
        $table->string('main_image')->nullable();
        $table->json('gallery_images')->nullable();
        // Example: ["img1.jpg","img2.jpg"]

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_models');
    }
};
