<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\SlimzaDeals;
use App\Services\SupabaseStorageService;
use App\Models\ProductsModel;


class WebRoutController extends Controller
{
     public function getHome()
    {
        $categories = CategoriesModel::all(); // get all records
        return view('pages.home', compact('categories'));
    }
     public function getAbout()
    {
        return view('about');
    }




 public function getFindProducts($slug, $id)
{
    // FETCH DEAL
    $deal = SlimzaDeals::findOrFail($id);

    // FIX DEAL IMAGE
    $deal->image = $deal->image
        ? SupabaseStorageService::getPublicUrl($deal->image)
        : null;

    // FETCH PRODUCTS RELATED TO THIS DEAL
    $products = ProductsModel::where('deal_id', $id)
        ->latest()
        ->get();

    // FIX PRODUCT IMAGES (IMPORTANT PART)
    $products->transform(function ($product) {
        $product->main_image = $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null;

        return $product;
    });

    return view('pages.find-product', compact('deal', 'products'));
}




  public function aboutUsView()
{

    return view('pages.about-us');
}

     public function faqView()
{

    return view('pages.faq');
}
  public function returnView()
{

    return view('pages.policy');
}






public function shippingCost()
    {
        return view('connections.shipping-cost');
    }

    public function thirtyDaysGuarantee()
    {
        return view('connections.30-days-guarantee');
    }

  

    public function privacyPolicy()
    {
        return view('connections.privacy-policy');
    }

 public function getProductDetails($slug,$id)
{
    $product = ProductsModel::findOrFail($id);

    $categories = CategoriesModel::pluck('name', 'id');

    $formattedProduct = $this->formatProduct($product, $categories);

    return view('products.product-details', [
        'product' => (object) $formattedProduct
    ]);
}


private function formatProduct($product, $categories = null)
{
    $categories = $categories ?? CategoriesModel::pluck('name', 'id');

    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'sku' => $product->sku,
        'price' => $product->price,
        'old_price' => $product->old_price,
        'stock' => $product->stock,
        'category_id' => $product->category_id,
        'deal_id' => $product->deal_id,

        'category_name' => $categories[$product->category_id] ?? 'Uncategorized',

        'weights' => json_decode($product->weights, true) ?: [],

        'main_image' => $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null,

        'gallery_images' => collect(json_decode($product->gallery_images, true) ?: [])
            ->filter()
            ->map(fn ($img) => SupabaseStorageService::getPublicUrl($img))
            ->values()
            ->toArray(),
    ];
}

   
}
