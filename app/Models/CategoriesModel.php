<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsModel;
class CategoriesModel extends Model
{
     protected $table = 'categories_models';
     protected $fillable = [
        'name',
        'image',
    ];
  public function products()
{
    return $this->hasMany(ProductsModel::class, 'category_id');
}
}
