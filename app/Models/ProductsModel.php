<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products_models';

    protected $fillable = [
        'name',
        'description',
        'sku',
        'category_id',
        'price',
        'old_price',
        'stock',
        'weights',
        'main_image',
        'gallery_images',
        'deal_id',
    ];

    protected $casts = [
        'weights' => 'array',
        'gallery_images' => 'array',
    ];
}
