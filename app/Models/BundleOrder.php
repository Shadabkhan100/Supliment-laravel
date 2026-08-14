<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleOrder extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'address_1',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'notes',
        'lat',
        'lng',
        'products',
        'item_count',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'total',
        'user_id',
        'guest_id',
        'payment_status',
        'order_status',
    'payment_status',
    'currency',
    'paid_amount',
    'payment_intent',
    'stripe_session_id',
    ];

    protected $casts = [
        'products' => 'array'
    ];
}