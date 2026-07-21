<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    protected $table = 'subscribers';

    protected $fillable = [
        // Existing fields
        'email',
        'ip_address',
        'location',
        'latitude',
        'longitude',
        'device_model',
        'plan',

        // Subscription fields
        'user_id',
        'product_id',
        'frequency',
        'discount',
        'status',
        'next_billing_date',
    ];

    protected $casts = [
        'latitude'          => 'float',
        'longitude'         => 'float',
        'discount'          => 'float',
        'next_billing_date' => 'datetime',
    ];
}