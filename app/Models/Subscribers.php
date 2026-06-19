<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
       protected $fillable = [
        'email',
        'ip_address',
        'location',
        'latitude',
        'longitude',
        'device_model',
        'plan',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
