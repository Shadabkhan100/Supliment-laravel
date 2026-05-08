<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;

class AdminWebController extends Controller
{
    
       public function getAddProduct()
    {
        // FETCH ALL CATEGORIES
        $categories = CategoriesModel::latest()->get();
        $products = ProductsModel::latest()->get();
        // SEND TO VIEW
        return view('admin.product-management', compact('categories','products'));
    }

    public function getAddCatrgory()
    {
       
        return view('admin.category-form');
    }
 
}
