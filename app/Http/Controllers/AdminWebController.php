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

    public function getUpdateBannerView()
    {
       
        return view('admin.page-settings');
    }
public function getDealsManagement()
    {
       
        return view('admin.deals-management');
    }
public function getBlogsManagements()
    {
       
        return view('admin.blogs-managements');
    }
public function getFutureProducts()
    {
       
        return view('admin.future-products-management');
    }
public function getTestimonialmanagement()
    {
       
        return view('admin.testimonials');
    }
 
}
