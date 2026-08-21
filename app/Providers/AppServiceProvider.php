<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\CartModel;
use Illuminate\Support\Facades\Auth;
use App\Models\WebModel;
use App\Models\PromoCode;



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
    $symbol = $config['symbol'] ?? '£';

    $cartItems = collect();
    $promoCode = null;

    /*
    |--------------------------------------------------------------------------
    | Authenticated User
    |--------------------------------------------------------------------------
    */

    if ($user) {

        // AUTH USER CART
        $cartItems = CartModel::where('user_id', $user->id)
            ->get();

        // AUTH USER PROMO
        $promoCode = PromoCode::where('user_id', $user->id)
            ->where('is_used', 0)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

    } else {

        /*
        |--------------------------------------------------------------------------
        | Guest User
        |--------------------------------------------------------------------------
        */

        $guestId = app('request')->cookie('guest_id');

        if ($guestId) {

            // GUEST CART
            $cartItems = CartModel::where('guest_id', $guestId)
                ->get();

            // GUEST PROMO
            $promoCode = PromoCode::where('guest_id', $guestId)
                ->where('is_used', 0)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Website Settings
    |--------------------------------------------------------------------------
    */

    $websiteSetting = WebModel::find(2);

    /*
    |--------------------------------------------------------------------------
    | Cart Count
    |--------------------------------------------------------------------------
    */

    $cartCount = $cartItems->count();

    /*
    |--------------------------------------------------------------------------
    | Cart Total
    |--------------------------------------------------------------------------
    */

    $cartTotal = $cartItems->sum(function ($item) use ($rate) {

        return ($item->price ?? 0)
            * ($item->quantity ?? 1)
            * $rate;
    });

    /*
    |--------------------------------------------------------------------------
    | Share With All Views
    |--------------------------------------------------------------------------
    */

    $view->with([

        'cartCount'      => $cartCount,
        'cartTotal'      => $cartTotal,
        'currencySymbol' => $symbol,
        'authUser'       => $user,
        'websiteSetting' => $websiteSetting,
        'promoCode'      => $promoCode,

    ]);

});
}
}