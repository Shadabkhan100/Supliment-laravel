<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartModel;
use App\Models\GuestOrder;
use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Services\SupabaseStorageService;
 use App\Models\Subscribers;
use Illuminate\Support\Facades\Validator;
use App\Models\SlimzaDeals;
use App\Models\BundleOrder;




class ProfileController extends Controller
{


    public function getProfileView()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // ✅ Cart items
        $cartItems = CartModel::where('user_id', $user->id)->get();

        // ✅ User orders (IMPORTANT FIX)
     $orders = GuestOrder::where('user_id', $user->id)
    ->latest()
    ->get()
    ->map(function ($order) {

        $product = ProductsModel::find($order->product_id);

        $option = [];

        if (!empty($order->product_option)) {
            $option = is_string($order->product_option)
                ? json_decode($order->product_option, true)
                : (array) $order->product_option;
        }

        return [
            'id'             => $order->id,
            'order_id'       => $order->id,

            'product_id'     => $order->product_id,

            'quantity'       => $order->quantity,
            'purchase_type'  => $order->purchase_type,

            'name'           => $order->name,
            'email'          => $order->email,
            'phone'          => $order->phone,

            'address1'       => $order->address1,
            'city'           => $order->city,
            'postal'         => $order->postal,
            'country'        => $order->country,
            'lat'            => $order->lat,
            'lng'            => $order->lng,

            'order_status'   => $order->order_status ?? 'Pending',
            'payment_status' => (int) $order->payment_status,

            'product' => [
                'name'  => $product->name ?? 'Product',
                'image' => $product?->main_image
                    ? \App\Services\SupabaseStorageService::getPublicUrl($product->main_image)
                    : '/images/placeholder.png',
                'price' => $product->price ?? 0,
            ],

            'product_option' => $option,

            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    });

        // ✅ Avatar fix
        if ($user->avatar && $user->avatar !== '') {
            $user->avatar = SupabaseStorageService::getPublicUrl($user->avatar);
        }
      $deal = SlimzaDeals::findOrFail(6);
      $subscriptions = $this->getSubscribers();



       $userId=$user->id;

$query = BundleOrder::query();

if (!empty($userId)) {
    $query->where('user_id', $userId);
} elseif (!empty($guestId)) {
    $query->where('guest_id', trim($guestId));
}

$bundleOrders = $query
    ->latest()
    ->get();



return view('profile.user-profile', compact(
    'user',
    'cartItems',
    'orders',
    'deal',
    'subscriptions','bundleOrders'
));
    }







    // ✅ CLEAN PRODUCT FORMATTER
    private function formatProduct($product, $categories = null)
    {
        $categories = $categories ?? CategoriesModel::pluck('name', 'id');

        $options = collect(
            is_string($product->options)
                ? json_decode($product->options, true)
                : ($product->options ?? [])
        )->filter()->values();

        $finalPrice = (float) $product->price;

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
            'price' => $finalPrice,
            'old_price' => $product->old_price,
            'stock' => $product->stock,
            'category_name' => $categories[$product->category_id] ?? 'Uncategorized',

            'main_image' => $product->main_image
                ? SupabaseStorageService::getPublicUrl($product->main_image)
                : null,

            'options' => $options->toArray(),
        ];
    }





public function subscribe(Request $request)
{
    try {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userAgent = $request->header('User-Agent');

        $device = 'Desktop';

        if (stripos($userAgent, 'mobile') !== false) {
            $device = 'Mobile';
        } elseif (stripos($userAgent, 'tablet') !== false) {
            $device = 'Tablet';
        }

        Subscribers::updateOrCreate(
            ['email' => $request->email],
            [
                'ip_address' => $request->ip(),
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'device_model' => $device,
                'plan' => $request->plan,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Server error',
            'error' => $e->getMessage()
        ], 500);
    }
}










public function getSubscription(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'frequency'  => 'required|string',
        'discount'   => 'required|numeric'
    ]);

    $userId = Auth::id();

    if (!$userId) {
        return response()->json([
            'status' => false,
            'message' => 'Please login first.'
        ], 401);
    }

    // Prevent duplicate subscriptions for the same product
    $exists = Subscribers::where('user_id', $userId)
        ->where('product_id', $request->product_id)
        ->where('status', 'active')
        ->first();

    if ($exists) {
        return response()->json([
            'status' => false,
            'message' => 'You have already subscribed to this product.'
        ]);
    }

    $subscription = Subscribers::create([
        'user_id'      => $userId,
        'product_id'   => $request->product_id,
        'frequency'    => $request->frequency,
        'discount'     => $request->discount,
        'status'       => 'active'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Subscription added successfully.',
        'data' => $subscription
    ]);
}



public function cancelSubscription(Request $request)
{
    try {

        $request->validate([
            'product_id' => 'required|integer',
            'user_id'    => 'required|integer',
        ]);

        $subscription = Subscribers::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription not found.'
            ], 404);
        }

        // Delete the record
        $subscription->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subscription cancelled successfully.'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}




private function getSubscribers()
{
    $userId = Auth::id();

    if (!$userId) {
        return collect();
    }

    $categories = CategoriesModel::pluck('name', 'id');

    return Subscribers::where('user_id', $userId)
        ->latest()
        ->get()
        ->map(function ($subscription) use ($categories) {

            $product = ProductsModel::find($subscription->product_id);

            return [
                'id'          => $subscription->id,
                'product_id'  => $subscription->product_id,
                'frequency'   => $subscription->frequency,
                'discount'    => $subscription->discount,
                'status'      => $subscription->status,
                'created_at'  => $subscription->created_at,
                'updated_at'  => $subscription->updated_at,

                'product' => $product
                    ? $this->formatProduct($product, $categories)
                    : null,
            ];
        });
}
}