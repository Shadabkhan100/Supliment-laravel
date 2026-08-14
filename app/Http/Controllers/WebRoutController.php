<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\SlimzaDeals;
use App\Services\SupabaseStorageService;
use App\Models\ProductsModel;
use Illuminate\Support\Str;
use App\Models\Blogs;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscribers;
use App\Models\BundleOrder;

use App\Models\GuestOrder;

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


public function shopAll()
{
    $products = ProductsModel::all()
        ->map(function ($product) {

            $tags = json_decode($product->tags, true) ?? [];

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
                'category_name' => $product->category_name ?? 'Uncategorized',

                // TAGS (raw)
                'tags' => $tags,

                // MAIN IMAGE (Supabase URL)
                'main_image' => $product->main_image
                    ? SupabaseStorageService::getPublicUrl($product->main_image)
                    : null,

                // GALLERY IMAGES (Supabase URLs)
                'gallery_images' => collect(json_decode($product->gallery_images, true) ?? [])
                    ->map(fn ($img) => $img ? SupabaseStorageService::getPublicUrl($img) : null)
                    ->values()
                    ->toArray(),
            ];
        });

    return view('pages.shop-all', compact('products'));
}



 public function getFindProducts($slug, $id)
{
    $deal = SlimzaDeals::findOrFail($id);

    $deal->image = $deal->image
        ? SupabaseStorageService::getPublicUrl($deal->image)
        : null;

    $products = ProductsModel::where('deal_id', $id)
        ->latest()
        ->get();

    $products->transform(function ($product) {
        $product->main_image = $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null;

        return $product;
    });

    if ($deal->title === "BUNDLE DEALS") {
        return redirect("/make-your-own-offer");
    }

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

public function getProductDetails($slug, $id)
{
    $product = ProductsModel::findOrFail($id);

    $categories = CategoriesModel::pluck('name', 'id');

    $formattedProduct = $this->formatProduct($product, $categories);

    // =========================
    // FIND LOWEST OPTION PRICE (SAFE ARRAY FIX)
    // =========================
    if (
        isset($formattedProduct['options']) &&
        is_array($formattedProduct['options']) &&
        count($formattedProduct['options']) > 0
    ) {

        $prices = array_values(array_filter(array_map(function ($opt) {
            return isset($opt['price']) ? (float) $opt['price'] : null;
        }, $formattedProduct['options'])));

        if (count($prices) > 0) {
            $formattedProduct['price'] = min($prices);
        }
    }

    // =========================
    // FIND MATCHING DEAL (BASED ON PRODUCT deal_id)
    // =========================
    $deal = SlimzaDeals::where('id', $product->deal_id)->first();

    return view('products.product-details', [
        'product' => (object) $formattedProduct,
        'deal' => $deal
    ]);
}

private function formatProduct($product, $categories = null)
{
    $categories = $categories ?? CategoriesModel::pluck('name', 'id');

    // =========================
    // OPTIONS NORMALIZATION
    // =========================
    $options = is_string($product->options)
        ? json_decode($product->options, true)
        : $product->options;

    $options = is_array($options) ? array_values(array_filter($options)) : [];
    // =========================
    // DEFAULT PRICE (DB PRICE)
    // =========================
    $finalPrice = (float) $product->price;

    // =========================
    // OVERRIDE WITH LOWEST OPTION PRICE
    // =========================
    if (count($options) > 0) {
        $prices = array_values(array_filter(array_map(function ($opt) {
            return (isset($opt['price']) && is_numeric($opt['price']))
                ? (float) $opt['price']
                : null;
        }, $options)));

        if (count($prices) > 0) {
            $finalPrice = min($prices);
        }
    }
    $userId = Auth::id();
$subscription = null;
if ($userId) {
    $subscription = Subscribers::where('user_id', $userId)
        ->where('product_id', $product->id)
        ->where('status', 'active')
        ->first();
}

    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'sku' => $product->sku,
        // FINAL PRICE
        'price' => $finalPrice,
        'old_price' => $product->old_price,

        'stock' => $product->stock,
        'category_id' => $product->category_id,
        'deal_id' => $product->deal_id,
            'ingredients' => $product->ingredients,

        'category_name' => $categories[$product->category_id] ?? 'Uncategorized',

        'weights' => json_decode($product->weights, true) ?: [],

        // normalized options
        'options' => $options,

        // =========================
        // NEW FIELDS ADDED (SAFE)
        // =========================
        'shipping_info' => $product->shipping_info ?? null,
        'supplement_facts' => $product->supplement_facts ?? null,
        'how_to_use' => $product->how_to_use ?? null,
        'halal_certification' => $product->halal_certification
            ? SupabaseStorageService::getPublicUrl($product->halal_certification)
            : null,

        'main_image' => $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null,

        'gallery_images' => collect(json_decode($product->gallery_images, true) ?: [])
            ->filter()
            ->map(fn ($img) => SupabaseStorageService::getPublicUrl($img))
            ->values()
            ->toArray(),

        'subscribed' => $subscription ? true : false,
        'subscription' => $subscription,
    ];
}



public function searchByTag($tag)
{
    $products = ProductsModel::all()
        ->filter(function ($product) use ($tag) {

            $tags = json_decode($product->tags, true) ?? [];

            $normalizedTags = array_map(function ($t) {
                return Str::slug($t);
            }, $tags);

            return in_array($tag, $normalizedTags);
        })
        ->map(function ($product) {

            $tags = json_decode($product->tags, true) ?? [];

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
                'category_name' => $product->category_name ?? 'Uncategorized',

                // ✅ TAGS (keep original + normalized if needed)
                'tags' => $tags,

                // =========================
                // SUPABASE IMAGE URLS
                // =========================
                'main_image' => $product->main_image
                    ? SupabaseStorageService::getPublicUrl($product->main_image)
                    : null,

                'gallery_images' => collect(json_decode($product->gallery_images, true) ?? [])
                    ->map(fn ($img) => $img ? SupabaseStorageService::getPublicUrl($img) : null)
                    ->values()
                    ->toArray(),
            ];
        });

    return view('products.searchProducts', compact('products', 'tag'));
}



      public function getAllBlogs()
    {
        return view('pages.blogs');
    }

 public function contactView()
    {
        return view('pages.contact');
    }

 public function authPage()
    {
        return view('pages.auth');
    }
     

public function shopDetails($slug, $id)
{
     // 1. Get category
    $category = CategoriesModel::findOrFail($id);

    // 2. Convert category image (SUPABASE)
    $category->image = $category->image
        ? SupabaseStorageService::getPublicUrl($category->image)
        : null;

    // 3. Get products under this category
    $products = ProductsModel::where('category_id', $id)->get();

    // 4. Convert product images (SUPABASE)
    $products = $products->map(function ($product) {

        $product->image = $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null;

        return $product;
    });
    // 3. Pass slug + products to view
    return view('pages.shop-details', [
        'category_slug' => $slug,
         "category" => $category,
        'products' => $products,
    ]);
}






public function getGuestProfileView(Request $request)
{
    $guestId = $request->cookie('guest_id');

    if (!$guestId) {
        return redirect('/login');
    }

    $orders = GuestOrder::with('product')
        ->where('guest_id', trim($guestId))
        ->latest()
        ->get()
        ->map(function ($o) {

            $product = $o->product;

            $option = [];

            if (!empty($o->product_option)) {
                $option = is_string($o->product_option)
                    ? json_decode($o->product_option, true)
                    : (array) $o->product_option;
            }

            $productName = $product->name ?? 'Product';

            $productImage = $product->main_image
                ? \App\Services\SupabaseStorageService::getPublicUrl($product->main_image)
                : null;

            $productPrice = $product->price ?? 0;

            $image = $option['image']
                ?? $productImage
                ?? '/images/placeholder.png';

            $price = $option['price']
                ?? $productPrice;

            $name = $option['name']
                ?? $productName;

            return [
                'id'             => $o->id,
                'order_id'       => $o->id,
                'product_id'     => $o->product_id,
                'quantity'       => $o->quantity,
                'purchase_type'  => $o->purchase_type,
                'payment_status' => (bool) $o->payment_status,
                'name'           => $o->name,
                'email'          => $o->email,
                'phone'          => $o->phone,
                'address1'       => $o->address1,
                'city'           => $o->city,
                'postal'         => $o->postal,
                'country'        => $o->country,
                'lat'            => $o->lat,
                'lng'            => $o->lng,
                'order_status'   => $o->order_status ?? 'Pending',

                'product' => [
                    'name'  => $name,
                    'image' => $image,
                    'price' => (float) $price,
                ],

                'product_option' => $option,
                'created_at'     => $o->created_at,
                'updated_at'     => $o->updated_at,
            ];
        });

    $user = (object)[
        'name'    => 'Guest User',
        'email'   => 'guest@local',
        'phone'   => null,
        'country' => null,
        'address' => null,
    ];

    $userId = Auth::id();

    $bundleOrders = BundleOrder::query()
        ->when($userId, function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->when(!$userId && $guestId, function ($query) use ($guestId) {
            $query->where('guest_id', trim($guestId));
        })
        ->latest()
        ->get();

    // Redirect only if BOTH normal orders and bundle orders are empty
    if ($orders->isEmpty() && $bundleOrders->isEmpty()) {
        return redirect('/login');
    }



    return view('profile.guest', compact(
        'user',
        'orders',
        'guestId',
        'bundleOrders'
    ));
}






   public function ensureGuestId(Request $request)
{
    $guestId = $request->cookie('guest_id');

    if (!$guestId) {
        $guestId = (string) Str::uuid();

        return response()
            ->json(['guest_id' => $guestId])
            ->cookie(
                'guest_id',
                $guestId,
                60 * 24 * 30, // 30 days
                '/',
                null,
                false,
                false
            );
    }

    return response()->json(['guest_id' => $guestId]);
}







public function mixMatchView()
{
    $products = ProductsModel::all();
    $categories = CategoriesModel::all();
    $cat = CategoriesModel::pluck('name', 'id');

    $products = $products->map(function ($product) use ($cat) {
        return $this->formatProduct($product, $cat);
    });

    return view('pages.mix-match', compact('products','categories'));
}
}
