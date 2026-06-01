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
        Schema::create('cart_models', function (Blueprint $table) {
            $table->id();
            
    $table->unsignedBigInteger('user_id');

    $table->unsignedBigInteger('product_id');

    $table->json('option'); // pack, price, discount, etc

    $table->integer('quantity')->default(1);

    $table->string('purchase_type'); // one_time / subscribe

    $table->decimal('price', 10, 2)->nullable();
    $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_models');
    }
};
