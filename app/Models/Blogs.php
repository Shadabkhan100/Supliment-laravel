<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'short_description',
        'description',
        'image',
        'publish_date',
        'status',
    ];
}