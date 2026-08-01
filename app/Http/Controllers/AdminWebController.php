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
use App\Models\WebModel;
use App\Models\BundleOrder;
use App\Services\UserEmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;


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
            'lat' =>  $order->lat,
             'lng' =>  $order->lng,
             'paid_amount' =>  $order->paid_amount,
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





public function getSettingsView(Request $request)
{
    $setting = WebModel::first();

    if ($setting) {
        $setting->logo = $setting->logo
            ? SupabaseStorageService::getPublicUrl($setting->logo)
            : null;

        $setting->favicon = $setting->favicon
            ? SupabaseStorageService::getPublicUrl($setting->favicon)
            : null;

        $setting->og_image = $setting->og_image
            ? SupabaseStorageService::getPublicUrl($setting->og_image)
            : null;
    }

    $search = $request->search;

    $admins = User::whereIn('status', ['Admin', 'Sub Admin'])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5)
        ->withQueryString();

    return view('admin.settings', compact('setting', 'admins'));
}










public function getUsersView()
{
    return view('admin.users');
}



public function addProductPack(Request $request, $p_id)
{
    try {

        $product = ProductsModel::findOrFail($p_id);

        $options = $product->options;

        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        if (!is_array($options)) {
            $options = [];
        }

        $options[] = [
            'pack' => (int) $request->pack,
            'price' => (float) $request->price,
            'duration' => $request->duration,
            'image' => $request->image // Supabase public URL
        ];

        $product->options = $options;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => 'Pack added successfully.',
            'data' => end($options)
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ], 500);

    }
}


public function updateProductPack(Request $request, $p_id, $index)
{
    try {

        $product = ProductsModel::findOrFail($p_id);

        $options = $product->options;

        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        if (!is_array($options)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid options data.'
            ], 400);
        }

        if (!isset($options[$index])) {
            return response()->json([
                'status' => false,
                'message' => 'Pack index not found.'
            ], 404);
        }

        // Keep existing image
        $image = $options[$index]['image'] ?? null;

        if ($request->hasFile('image')) {

            // Delete old image if you have a delete method
            // if ($image) {
            //     SupabaseStorageService::delete($image);
            // }

            $path = SupabaseStorageService::upload(
                $request->file('image'),
                'products/options'
            );

            $image = SupabaseStorageService::getPublicUrl($path);
        }

        $options[$index] = [
            'pack'     => (int) $request->pack,
            'price'    => (float) $request->price,
            'duration' => $request->duration,
            'image'    => $image,
        ];

        $product->options = $options;
        $product->save();

        return response()->json([
            'status'  => true,
            'message' => 'Pack updated successfully.',
            'image'   => $image,
            'data'    => $options[$index]
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status'  => false,
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine()
        ], 500);

    }
}






public function deleteProductPack($p_id, $index)
{
    try {

        $product = ProductsModel::findOrFail($p_id);

        $options = $product->options;

        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        if (!is_array($options)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid options data.'
            ], 400);
        }

        if (!isset($options[$index])) {
            return response()->json([
                'status' => false,
                'message' => 'Pack not found.'
            ], 404);
        }

        // Optional: delete image from Supabase if you store the path
        // if (!empty($options[$index]['image'])) {
        //     SupabaseStorageService::delete($options[$index]['image']);
        // }

        unset($options[$index]);

        // Re-index array
        $options = array_values($options);

        $product->options = $options;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => 'Pack deleted successfully.'
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
            'file' => basename($e->getFile()),
            'line' => $e->getLine()
        ], 500);

    }
}


public function deleteAdmin($id)
{
    try {

        $admin = User::findOrFail($id);

        // Prevent deleting the main admin if desired
        if ($admin->status !== 'Admin' && $admin->status !== 'Sub Admin') {
            return redirect()->back()->with('error', 'Invalid administrator.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Administrator deleted successfully.');

    } catch (\Exception $e) {

        return redirect()->back()->with('error', 'Something went wrong.');

    }
}



public function getBundleView()
{
    $bundleOrders = BundleOrder::latest()->get();

    return view('admin.bundle-view', [
        'bundleOrders' => $bundleOrders
    ]);
}




public function updateStatus($id, $status)
{
    try {

        $order = BundleOrder::findOrFail($id);

        $order->order_status = $status;

    

        $currentStatus = $status;

        $product = $order->products;
        $order->save();
        Mail::to($order->email)->send(
            new OrderStatusMail(
                $order,
                $product,
                $currentStatus
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Status update failed.',
            'error' => [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]
        ], 500);
    }
}
}