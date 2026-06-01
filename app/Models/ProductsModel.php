<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SlimzaDeals;

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
        'tags',
        'weights',
        'options',
        'main_image',
        'gallery_images',
        'deal_id',
    ];

    protected $casts = [
        'weights' => 'array',
        'tags' => 'array',
        'gallery_images' => 'array',
        'options' => 'array',

    ];


   public function deal()
{
    return $this->belongsTo(SlimzaDeals::class, 'deal_id');
}
}
