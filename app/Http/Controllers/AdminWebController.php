<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\SlimzaDeals;
use App\Services\SupabaseStorageService;
class AdminWebController extends Controller
{
    
public function editPage($id)
{
    $product = ProductsModel::findOrFail($id);

    $categories = CategoriesModel::pluck('name', 'id');

    $product = $this->formatProduct($product, $categories);

    return view('admin.editProductPage', compact('product'));
}




      public function getAddProduct()
{
    // FETCH ALL CATEGORIES
    $categories = CategoriesModel::latest()->get();

    // FETCH ALL PRODUCTS
    $products = ProductsModel::latest()->get();

    // FETCH ALL DEALS (from SlimzaDeals DB/model)
    $deals = SlimzaDeals::latest()->get();

    // SEND TO VIEW
    return view('admin.product-management', compact('categories', 'products', 'deals'));
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

public function getDashboardView()
    {
       
        return view('admin.dashboard');
    }

 
}
