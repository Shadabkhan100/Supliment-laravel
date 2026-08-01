<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebModel extends Model
{
    protected $table = 'web_models'; // Remove this if your table follows Laravel's default naming

    protected $fillable = [
        'website_title',
        'meta_description',
        'logo',
        'favicon',
        'promotion_text',
        'support_email',
        'og_image',
        'canonical_url',
    ];
}