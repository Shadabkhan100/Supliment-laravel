<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\CartModel;
use App\Models\GuestOrder;
use App\Models\CategoriesModel;
use App\Services\SupabaseStorageService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsModel;
use App\Services\UserEmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartOrderMail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Stripe\PaymentIntent;
use Stripe\Refund;






class PaymentController extends Controller

{



public function checkout(Request $request)
{
    $total = (float) $request->total;
    $orderIds = explode(',', $request->order_ids);

    Stripe::setApiKey(config('services.stripe.secret'));

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',

        'line_items' => [[
            'price_data' => [
                'currency' => 'gbp',
                'product_data' => [
                    'name' => 'Cart Payment',
                ],
                'unit_amount' => intval($total * 100),
            ],
            'quantity' => 1,
        ]],

        'metadata' => [
            'order_ids' => implode(',', $orderIds),
        ],

        'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('stripe.cancel'),
    ]);

    return redirect($session->url);
}






public function success(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    try {

        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        $orderIds = isset($session->metadata->order_ids)
            ? array_filter(explode(',', $session->metadata->order_ids))
            : [];

        if (empty($orderIds)) {
            return view('payment-gateway.success', [
                'message' => 'No order IDs found in Stripe session',
                'orders' => []
            ]);
        }

        // Actual Stripe values
        $currency = strtoupper($session->currency);          // GBP, USD, SAR...
        $amountPaid = $session->amount_total / 100;          // Stripe returns cents

        GuestOrder::whereIn('id', $orderIds)
            ->update([
                'payment_status' => 1,
                'currency'       => $currency,
                'paid_amount'    => $amountPaid,
                'stripe_session_id' => $session->id,
                'payment_intent' => $session->payment_intent,
            ]);

        return view('payment-gateway.success', [
            'message' => 'Payment successful',
            'orders' => $orderIds,
            'updated_rows' => count($orderIds)
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Payment success handler failed',
            'error' => $e->getMessage()
        ], 500);
    }
}


private function createOrdersFromAuthCart(array $cartIds, Request $request)
{
    $user = auth()->user();

    if (!$user) {
        throw new \Exception('User not authenticated');
    }

    $orders = [];

    $carts = CartModel::whereIn('id', $cartIds)
        ->where('user_id', $user->id)
        ->get();

    foreach ($carts as $cart) {

        $order = GuestOrder::create([

            'product_id'     => $cart->product_id,
            'product_option' => $cart->option,
            'quantity'       => $cart->quantity,
            'purchase_type'  => $cart->purchase_type,

            'name'           => $user->name,
            'email'          => $user->email,
            'phone'          => $user->phone,

            'address1'       => $request->address1 ?? $user->address,
            'city'           => $request->city ?? $user->city,
            'postal'         => $request->postal,
            'country'        => $request->country ?? $user->country,

            'lat'            => $request->lat,
            'lng'            => $request->lng,

            'payment_status' => 0,

            'user_id'        => $user->id,
            'guest_id'       => null,

            'cart_payload'   => null,
        ]);

        $orders[] = $order->id;
    }

    return $orders;
}




private function createOrdersFromGuestCart(array $cartIds, Request $request)
{
    try {

        $guestId = $request->cookie('guest_id');

        if (!$guestId) {
            return [
                'status' => false,
                'message' => 'Guest ID not found in cookie'
            ];
        }

        $carts = CartModel::whereIn('id', $cartIds)
            ->where('guest_id', $guestId)
            ->get();

        if ($carts->isEmpty()) {
            return [
                'status' => false,
                'message' => 'No valid cart items found for this guest'
            ];
        }

        $orders = [];

        foreach ($carts as $cart) {

            $order = GuestOrder::create([
                'product_id'     => $cart->product_id,
                'product_option' => $cart->option,
                'quantity'       => $cart->quantity,
                'purchase_type'  => $cart->purchase_type,

                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,

                'address1'       => $request->address1,
                'city'           => $request->city,
                'postal'         => $request->postal,
                'country'        => $request->country,

                'lat'            => $request->lat,
                'lng'            => $request->lng,

                'payment_status' => 0,

                'user_id'        => null,
                'guest_id'       => $guestId,

                'cart_payload'   => null,
            ]);

            $orders[] = $order->id;
        }

        return [
            'status' => true,
            'message' => 'Orders created successfully',
            'orders' => $orders
        ];

    } catch (\Throwable $e) {

        Log::error('Guest Order Creation Failed', [
            'error' => $e->getMessage(),
            'cart_ids' => $cartIds,
            'guest_id' => $request->cookie('guest_id')
        ]);

        return [
            'status' => false,
            'message' => 'Something went wrong while creating orders',
            'error' => $e->getMessage() // remove in production if needed
        ];
    }
}









public function createCartOrders(Request $request)
{
    try {

        // =========================
        // VALIDATION
        // =========================
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.product_option' => 'nullable|array',
            'items.*.purchase_type' => 'nullable|string',

            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',

            'address1' => 'nullable|string',
            'city' => 'nullable|string',
            'postal' => 'nullable|string',
            'country' => 'nullable|string',

            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        // =========================
        // USER / GUEST
        // =========================
        $user = auth()->user();

        $userId = $user?->id;

        $guestId = $request->cookie('guest_id');

        if (!$user && !$guestId) {
            $guestId = 'gst_' . Str::random(24);
        }

        $orderIds = [];
        $total = 0;

        // Added for email
        $orderedProducts = [];

        DB::beginTransaction();

        // =========================
        // PROCESS ITEMS
        // =========================
        foreach ($validated['items'] as $item) {

            $product = ProductsModel::find($item['product_id']);

            if (!$product) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => "Product not found",
                    'product_id' => $item['product_id']
                ], 404);
            }

            // ALWAYS trust DB price
            $price = (float) $product->price;

            $qty = (int) $item['quantity'];

            if ($qty <= 0) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => "Invalid quantity",
                    'product_id' => $product->id
                ], 422);
            }

            $subtotal = $price * $qty;
            $total += $subtotal;

            $order = GuestOrder::create([
                'product_id' => $product->id,
                'product_option' => json_encode($item['product_option'] ?? null),
                'quantity' => $qty,
                'purchase_type' => $item['purchase_type'] ?? 'default',

                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],

                'address1' => $validated['address1'],
                'city' => $validated['city'],
                'postal' => $validated['postal'],
                'country' => $validated['country'],

                'lat' => $validated['lat'],
                'lng' => $validated['lng'],

                // PAYMENT STATUS (0 = pending, 1 = paid)
                'payment_status' => 0,

                'user_id' => $userId,
                'guest_id' => $guestId,
            ]);

            $orderIds[] = $order->id;

            // Added for email
            $orderedProducts[] = [
                'order' => $order,
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        DB::commit();

        // =========================
        // SEND EMAIL
        // =========================
        $email = $validated['email'];

        try {

          Mail::to($email)->send(
    new CartOrderMail(
        $orderedProducts,
        $total,
        $validated
    )
);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);

        }

        // =========================
        // RESPONSE
        // =========================
        $response = response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'order_ids' => $orderIds,
            'total_price' => $total,
            'guest_id' => $guestId,"email" => $orderedProducts
        ]);

        // IMPORTANT: always attach cookie properly
        if ($guestId && !$request->cookie('guest_id')) {
            $response->cookie('guest_id', $guestId, 60 * 24 * 365);
        }

        return $response;

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Server error',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}






public function cancel()
{
    return view('payment-gateway.cancel');
}








public function refund($id)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    DB::beginTransaction();

    try {

        $order = GuestOrder::findOrFail($id);

        if (!$order->payment_intent) {
            return response()->json([
                'status' => false,
                'message' => 'Stripe Payment Intent not found.'
            ], 404);
        }

        $paymentIntent = PaymentIntent::retrieve($order->payment_intent);

        Refund::create([
            'charge' => $paymentIntent->latest_charge,
        ]);

        // Delete order only after successful refund
        $order->delete();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Order refunded successfully and removed permanently.'
        ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}