<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = [
        'description',
        'home_banner',
    ];
}