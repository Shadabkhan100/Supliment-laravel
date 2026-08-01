<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\CartModel;
use Illuminate\Support\Facades\Auth;
use App\Models\WebModel;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

   public function boot(): void
{
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }

    View::composer('*', function ($view) {

        $user = Auth::user();

        $currency = session('currency', 'GBP');
        $config = config("currency.currencies.$currency");

        $rate = $config['rate'] ?? 1;
        $symbol = $config['symbol'] ?? '$';

        $cartItems = collect();

        if ($user) {

            // AUTH USER CART
            $cartItems = CartModel::where('user_id', $user->id)->get();

        } else {

            // GUEST CART
           $guestId = app('request')->cookie('guest_id');

            if ($guestId) {
                $cartItems = CartModel::where('guest_id', $guestId)->get();
            }
        }
         $websiteSetting = WebModel::find(2);
        $cartCount = $cartItems->count();

        $cartTotal = $cartItems->sum(function ($item) use ($rate) {
            return ($item->price ?? 0) * ($item->quantity ?? 1) * $rate;
        });

        $view->with([
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'currencySymbol' => $symbol,
            'authUser' => $user,
            'websiteSetting'  => $websiteSetting,
        ]);
    });
}
}