<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebRoutController extends Controller
{
     public function getHome()
    {
        return view('pages.home');
    }
     public function getAbout()
    {
        return view('about');
    }

   
}
