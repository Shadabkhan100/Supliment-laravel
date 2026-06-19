<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsModel;


class GuestOrder extends Model
{
    protected $table = 'guest_orders';

    protected $fillable = [
        'product_id',
        'product_option',
        'quantity',
        'purchase_type',

        'name',
        'email',
        'phone',

        'address1',
        'city',
        'postal',
        'country',

        'lat',
        'lng',

        'payment_status',
        'cart_payload', 
        'order_status',
        'user_id',
        'guest_id'
        
    ];

    protected $casts = [
        'product_option' => 'array',
        'cart_payload' => 'array',
        'payment_status' => 'boolean',
    ];

   public function product()
{
    return $this->belongsTo(ProductsModel::class, 'product_id');
}
}