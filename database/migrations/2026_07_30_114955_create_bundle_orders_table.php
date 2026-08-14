<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bundle_orders', function (Blueprint $table) {
            $table->id();

            // Customer information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');

            $table->string('company')->nullable();

            $table->text('address_1');
            $table->text('address_2')->nullable();

            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postcode');
            $table->string('country');

            $table->text('notes')->nullable();

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // Bundle information
            $table->json('products');

            $table->integer('item_count');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('total', 10, 2);
$table->unsignedBigInteger('user_id')->nullable();
$table->string('guest_id')->nullable();
$table->boolean('payment_status')->default(0);
$table->string('order_status')->default('Pending');
$table->string('currency')->nullable();
$table->decimal('paid_amount', 10, 2)->nullable();
$table->string('payment_intent')->nullable();
$table->string('stripe_session_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundle_orders');
    }
};
