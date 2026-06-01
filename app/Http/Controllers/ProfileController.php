<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartModel;

class ProfileController extends Controller
{
    public function getProfileView()
    {
        $user = Auth::user();

        $cartItems = CartModel::where('user_id', $user->id)->get();

        return view('profile.user-profile', compact('user', 'cartItems'));
    }
}