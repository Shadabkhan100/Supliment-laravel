<?php

namespace App\Http\Controllers;

use App\Models\GuestOrder;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Services\SupabaseStorageService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Services\UserEmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
 use Illuminate\Support\Facades\Http;
use App\Models\WebModel;




class OrderController extends Controller
{



public function createAuthOrder(Request $request)
{
    // 🔐 Must be logged in (session-based auth)
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Please login first.'
        ], 401);
    }
    // ✅ Validate request
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'product_option' => 'nullable',
        'quantity' => 'required|integer',
        'purchase_type' => 'required|string',
         'currency' => 'required|string',

        'address1' => 'nullable|string',
        'city' => 'nullable|string',
        'postal' => 'nullable|string',
        'country' => 'nullable|string',

        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',

        'cart_payload' => 'nullable'
    ]);

    // 🔥 CREATE ORDER USING AUTH USER ONLY
    $order = GuestOrder::create([
        'product_id' => $validated['product_id'],
        'product_option' => $validated['product_option'] ?? null,
        'quantity' => $validated['quantity'],
        'purchase_type' => $validated['purchase_type'],
        'currency' => $validated['currency'],
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,

        'address1' => $validated['address1'] ?? $user->address,
        'city' => $validated['city'] ?? $user->city,
        'postal' => $validated['postal'] ?? null,
        'country' => $validated['country'] ?? $user->country,

        'lat' => $validated['lat'] ?? null,
        'lng' => $validated['lng'] ?? null,

        'payment_status' => false,
        'cart_payload' => $validated['cart_payload'] ?? null,

        // 🔥 IMPORTANT DIFFERENCE
        'user_id' => $user->id,
        'guest_id' => null,
    ]);
    $product = ProductsModel::find($validated['product_id']);
try {
    
  $currentStatus="Pending";

Mail::to($user->email)->send(
    new OrderStatusMail(
        $order,
        $product,
        $currentStatus
    )
);

    return response()->json([
        'status' => true,
        'message' => 'Mail sent'
    ]);

} catch (\Throwable $e) {

    return response()->json([
        'status' => false,
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], 500);

}
    return response()->json([
        'status' => true,
        'message' => 'Auth order created successfully',
        'order_id' => $order->id,
        'type' => "order"
    ]);
}


private function sendOrderStatusEmails($order, $product, $currentStatus)
{
    // Get admin email from website settings
    try {
        $websiteSetting = WebModel::find(2);

        $adminEmail = $websiteSetting->support_email ?? 'info@slimza.com';

        // If empty/null, use fallback
        if (empty($adminEmail)) {
            $adminEmail = 'info@slimza.com';
        }

    } catch (\Throwable $e) {
        // If anything goes wrong, use fallback email
        $adminEmail = 'info@slimza.com';
    }

    // Send to customer
    Mail::to($order->email)->send(
        new OrderStatusMail(
            $order,
            $product,
            $currentStatus
        )
    );

    // Send the exact same email to admin
    Mail::to($adminEmail)->send(
        new OrderStatusMail(
            $order,
            $product,
            $currentStatus
        )
    );
}






public function createGuestOrder(Request $request)
{
   
try {
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'product_option' => 'nullable',
        'quantity' => 'required|integer',
        'purchase_type' => 'required|string',
        'currency'=> 'required|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',

        'address1' => 'nullable|string',
        'city' => 'nullable|string',
        'postal' => 'nullable|string',
        'country' => 'nullable|string',

        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',

        'cart_payload' => 'nullable'
    ]);

    $user = auth()->user();

    if ($user) {

        $userId = $user->id;
        $guestId = null;

    } else {

        $userId = null;

        $guestId = $request->cookie('guest_id');

        if (!$guestId) {

            $guestId = 'gst_' . Str::random(24);

            Cookie::queue(
                'guest_id',
                $guestId,
                60 * 24 * 365
            );
        }
    }

    $product = ProductsModel::find($validated['product_id']);

    if (!$product) {

        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    $order = GuestOrder::create([
        'product_id' => $validated['product_id'],
        'product_option' => $validated['product_option'] ?? null,
        'quantity' => $validated['quantity'],
        'purchase_type' => $validated['purchase_type'],
         'currency' => $validated['currency'],
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],

        'address1' => $validated['address1'] ?? null,
        'city' => $validated['city'] ?? null,
        'postal' => $validated['postal'] ?? null,
        'country' => $validated['country'] ?? null,

        'lat' => $validated['lat'] ?? null,
        'lng' => $validated['lng'] ?? null,

        'payment_status' => false,

        'cart_payload' => $validated['cart_payload'] ?? null,

        'user_id' => $userId,
        'guest_id' => $guestId,
    ]);

    $mailStatus = false;
    $mailError = null;

    try {
      $currentStatus = "Pending";

$this->sendOrderStatusEmails(
    $order,
    $product,
    $currentStatus
);

$mailStatus = true;



    } catch (\Throwable $e) {

        $mailStatus = false;

        $mailError = [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];
    }

    return response()->json([
        'status' => true,
        'message' => 'Order created successfully',
        'order_id' => $order->id,
        'mail_sent' => $mailStatus,
        'mail_error' => $mailError,
          'order_ids' => [$order->id],
    'total_price' => $product->price * $validated['quantity'],
    ])->cookie(
        'guest_id',
        $guestId,
        60 * 24 * 365
    );

} catch (\Illuminate\Validation\ValidationException $e) {

    return response()->json([
        'status' => false,
        'message' => 'Validation failed',
        'errors' => $e->errors()
    ], 422);

} catch (\Throwable $e) {

    return response()->json([
        'status' => false,
        'message' => 'Order creation failed',
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], 500);
}

}

public function getGuestOrder()
{
    $orders = GuestOrder::latest()->get();

    if ($orders->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No orders found'
        ], 404);
    }

    $data = $orders->map(function ($order) {

        $product = ProductsModel::find($order->product_id);

        return [
            'order' => [
                'id' => $order->id,
                'quantity' => $order->quantity,
                'purchase_type' => $order->purchase_type,
                'payment_status' => $order->payment_status,
                'order_status' => $order->order_status,
                  'type' => "order",
                'user' => [
                    'name' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                    'address1' => $order->address1,
                    'city' => $order->city,
                    'postal' => $order->postal,
                    'country' => $order->country,
                    'lat' => $order->lat,
                    'lng' => $order->lng,
                ],
               
                'option' => $order->product_option,
            ],
         
            // product may be null-safe
            'product' => $product
                ? $this->formatProduct($product)
                : null,
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}




public function getGuestOrderbyId($id)
{
    $order = GuestOrder::find($id);

    if (!$order) {
        return response()->json([
            'status' => false,
            'message' => 'Order not found'
        ], 404);
    }

    $product = ProductsModel::find($order->product_id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => [
            'order' => [
                'id' => $order->id,
                'quantity' => $order->quantity,
                'purchase_type' => $order->purchase_type,
                'payment_status' => $order->payment_status,

                'user' => [
                    'name' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                    'address1' => $order->address1,
                    'city' => $order->city,
                    'postal' => $order->postal,
                    'country' => $order->country,
                    'lat' => $order->lat,
                    'lng' => $order->lng,
                ],

                'option' => $order->product_option,
            ],

            // FULL PRODUCT USING YOUR FORMAT FUNCTION
            'product' => $this->formatProduct($product),
        ]
    ]);
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



public function updateOrderStatus(Request $request, $id)
{
    try {

        if (!$request->status) {
            return response()->json([
                'success' => false,
                'message' => 'Status is required.'
            ], 422);
        }

        $currentStatus = $request->status;

        $order = GuestOrder::findOrFail($id);
        $product = ProductsModel::find($order->product_id);

        // Update status in memory
        $order->order_status = $currentStatus;

        // Send email only for required statuses
       if (
    ($currentStatus === 'Shipped') ||
    ($currentStatus === 'Delivered') ||
    ($currentStatus === 'Suspended')
) {

    Mail::to($order->email)->send(
        new OrderStatusMail(
            $order,
            $product,
            $currentStatus
        )
    );
}

        // Save after successful email (or immediately if no email required)
        $order->save();

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(), // Remove in production
        ], 500);
    }
}

public function ensureGuestId(Request $request)
{
    // 1. Try existing cookie
    $guestId = $request->cookie('guest_id');

    // 2. If not found, create new one
    if (!$guestId) {
        $guestId = (string) Str::uuid();

        return response()
            ->json([
                'status' => true,
                'guest_id' => $guestId
            ])
            ->cookie('guest_id', $guestId, 60 * 24 * 30, '/');
    }

    // 3. If already exists, just return it (NO new cookie set)
    return response()->json([
        'status' => true,
        'guest_id' => $guestId
    ]);
}





public function deleteOrder($id)
{
    try {
        $order = GuestOrder::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete order',
            'error' => $e->getMessage()
        ], 500);
    }
}















   public function usePromo($code)
{
    try {

        $promo = PromoCode::where('code', trim($code))
            ->where('user_id', auth()->id())
            ->where('is_used', 0)
            ->where('expires_at', '>', now())
            ->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired promo code.'
            ], 404);
        }

        $cartItems = CartModel::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 400);
        }

        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discountAmount = round(
            ($grandTotal * $promo->discount) / 100,
            2
        );

        $finalTotal = $grandTotal - $discountAmount;

        return response()->json([
            'success'           => true,
            'message'           => 'Promo code applied successfully.',
            'discount'          => $promo->discount,
            'discount_amount'   => $discountAmount,
            'grand_total'       => $grandTotal,
            'final_total'       => $finalTotal,
            'promo_code'        => $promo->code,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => 'Failed to apply promo code.',
            'error'   => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => basename($e->getFile()),
        ], 500);
    }
}




}