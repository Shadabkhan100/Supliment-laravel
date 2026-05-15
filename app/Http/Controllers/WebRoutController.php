<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\SlimzaDeals;
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
    $deal = SlimzaDeals::findOrFail($id);

    return view('pages.find-product', compact('deal'));
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
}
