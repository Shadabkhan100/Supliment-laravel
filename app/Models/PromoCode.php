<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
protected $fillable = [
    'user_id',
    'guest_id',
    'code',
    'discount',
    'expires_at',
    'is_used',
    'used_at',
   'order_id',
];
}
