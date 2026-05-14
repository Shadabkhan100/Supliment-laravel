<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutureProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'validity',
        'status',
    ];
}