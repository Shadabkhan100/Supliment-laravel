<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guest_orders', function (Blueprint $table) {
            $table->id();
            // PRODUCT INFO
            $table->unsignedBigInteger('product_id');
            $table->json('product_option')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('purchase_type')->default('one_time');
            $table->string('order_status')->default('Pending');
              
            // USER INFO (GUEST)
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            $table->text('address1')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->string('country')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('guest_id')->nullable()->index();
            // LOCATION FROM MAP
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

             // PAYMENT STATUS
            $table->tinyInteger('payment_status')->default(0);

            // RAW CART SNAPSHOT (IMPORTANT FOR AUDIT)
            $table->json('cart_payload')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->string('payment_intent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_orders');
    }
};