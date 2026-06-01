<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsModel;
class CartModel extends Model
{
    protected $table = 'cart_models';

    protected $fillable = [
        'user_id',
        'product_id',
        'option',
        'quantity',
        'purchase_type',
        'price'
    ];

    protected $casts = [
        'option' => 'array',
    ];



public function product()
{
    return $this->belongsTo(ProductsModel::class, 'product_id');
}
}