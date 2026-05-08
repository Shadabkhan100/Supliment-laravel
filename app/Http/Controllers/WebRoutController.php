<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
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

   
}
