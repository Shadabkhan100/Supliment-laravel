<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\SlimzaDeals;
use App\Services\SupabaseStorageService;
use Illuminate\Support\Facades\Auth;
use App\Models\GuestOrder;
use App\Models\Blogs;
use App\Models\CartModel;
use App\Models\FutureProduct;
use App\Models\PageSetting;
use App\Models\Testimonials;
use App\Models\User;
use App\Models\Subscribers;
use Stripe\Stripe;
use Stripe\Balance;


class AdminWebController extends Controller
{
    
public function editPage($id)
{
    $product = ProductsModel::findOrFail($id);

    $categories = CategoriesModel::pluck('name', 'id');

    $product = $this->formatProduct($product, $categories);

    return view('admin.editProductPage', [
        'product' => $product,

        'supabaseUrl' => config('supabase.url'),
        'supabaseKey' => config('supabase.key'),
        'supabaseBucket' => config('supabase.bucket'),
    ]);
}



public function getAddProduct()
{
    return view('admin.product-management', [
        'categories' => CategoriesModel::latest()->get(),
        'products' => ProductsModel::latest()->get(),
        'deals' => SlimzaDeals::latest()->get(),

        'supabaseUrl' => config('supabase.url'),
        'supabaseKey' => config('supabase.key'),
        'supabaseBucket' => config('supabase.bucket'),
    ]);
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
    $blogs = Blogs::all();
    $carts = CartModel::all();
    $categories = CategoriesModel::all();
    $futureProducts = FutureProduct::all();
    $guestOrders = GuestOrder::all();
    $products = ProductsModel::all();
    $slimzaDeals = SlimzaDeals::all();
    $subscribers = Subscribers::all();
    $testimonials = Testimonials::all();
    $users = User::all();
    $recentOrders = GuestOrder::latest('updated_at')->take(5)->get();

    // Currency rates
    $currencies = config('currency.currencies');

    $totalPaid = 0;
    $totalFailed = 0;

    foreach ($guestOrders as $order) {

        $price = 0;

        // Try getting price from product option
        $option = $order->product_option;

        if (is_string($option)) {
            $option = json_decode($option, true);
        }

        if (!empty($option) && isset($option['price'])) {

            $price = (float) $option['price'];

        } else {

            $product = $products->firstWhere('id', $order->product_id);

            if ($product) {
                $price = (float) $product->price;
            }
        }

        // Convert to GBP
        $currency = strtoupper($order->currency ?? 'GBP');

        if (isset($currencies[$currency])) {

            $rate = (float) $currencies[$currency]['rate'];

            if ($rate > 0) {
                $price /= $rate;
            }
        }

        if ($order->payment_status) {
            $totalPaid += $price;
        } else {
            $totalFailed += $price;
        }
    }

    // ==========================
    // LIVE STRIPE BALANCE
    // ==========================
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    $stripeBalance = \Stripe\Balance::retrieve();

    $availableBalance = collect($stripeBalance->available)->map(function ($balance) {
        return [
            'currency' => strtoupper($balance->currency),
            'amount'   => $balance->amount / 100,
        ];
    });

    $pendingBalance = collect($stripeBalance->pending)->map(function ($balance) {
        return [
            'currency' => strtoupper($balance->currency),
            'amount'   => $balance->amount / 100,
        ];
    });

    return view('admin.dashboard', compact(
        'blogs',
        'carts',
        'categories',
        'futureProducts',
        'guestOrders',
        'products',
        'slimzaDeals',
        'subscribers',
        'testimonials',
        'users',
        'recentOrders',
        'totalPaid',
        'totalFailed',
        'availableBalance',
        'pendingBalance'
    ));
}

public function showLogin()
    {
       
        return view('admin.auth.login');
    }
  public function showforget()
    {
       
        return view('admin.auth.forgot');
    }

public function getOrdersView()
{
    $orders = GuestOrder::latest()->get()->map(function ($order) {

        $product = ProductsModel::find($order->product_id);

        return [
            'id' => $order->id,
            'quantity' => $order->quantity,
            'purchase_type' => $order->purchase_type,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'created_at' => $order->created_at,

            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,

            'product' => $product ? $this->formatProduct($product) : null,
        ];
    });

    return view('admin.orders', compact('orders'));
}
private function formatProduct($product, $categories = null)
{
    $categories = $categories ?? CategoriesModel::pluck('name', 'id');

    // Decode options safely
    $options = collect(
        is_string($product->options)
            ? json_decode($product->options, true)
            : ($product->options ?? [])
    )->filter()->values();

    // Default price from DB
    $finalPrice = (float) $product->price;

    // If options exist → find lowest price
    if ($options->count() > 0) {

        $prices = $options
            ->pluck('price')
            ->filter()
            ->map(fn ($p) => (float) $p)
            ->values();

        if ($prices->count() > 0) {
            $finalPrice = $prices->min();
        }
    }

    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'sku' => $product->sku,

        // ✅ FINAL PRICE LOGIC HERE
        'price' => $finalPrice,
        'old_price' => $product->old_price,

        'stock' => $product->stock,
        'category_id' => $product->category_id,
        'deal_id' => $product->deal_id,

        'category_name' => $categories[$product->category_id] ?? 'Uncategorized',

        'weights' => json_decode($product->weights, true) ?? [],
        'tags' => json_decode($product->tags, true) ?? [],

        // keep original options
        'options' => $options->toArray(),

        // =========================
        // NEW FIELDS
        // =========================
        'shipping_info' => $product->shipping_info,
        'supplement_facts' => $product->supplement_facts,
        'how_to_use' => $product->how_to_use,

        'halal_certification' => $product->halal_certification
            ? SupabaseStorageService::getPublicUrl($product->halal_certification)
            : null,

        // =========================
        // SUPABASE IMAGE URLS
        // =========================
        'main_image' => $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null,

        'gallery_images' => collect(json_decode($product->gallery_images, true) ?? [])
            ->filter()
            ->map(fn ($img) => $img ? SupabaseStorageService::getPublicUrl($img) : null)
            ->values()
            ->toArray(),
    ];
}




public function getSettingsView()
{
    return view('admin.settings');
}

public function getUsersView()
{
    return view('admin.users');
}
}