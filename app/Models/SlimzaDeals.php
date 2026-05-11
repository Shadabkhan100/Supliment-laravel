<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlimzaDeals extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'image'
    ];
}
