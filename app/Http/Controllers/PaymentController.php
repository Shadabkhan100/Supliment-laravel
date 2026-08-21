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
use App\Services\OneSignalService;
use App\Models\BundleOrder;
use App\Models\PromoCode;


class PaymentController extends Controller

{


public function checkout(Request $request)
{
    $total = (float) $request->total;
    $orderIds = explode(',', $request->order_ids);

    // New field
    $type = $request->type ?? 'order';

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

            // Newly added field
            'type' => $type,
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

        // New field (defaults to the old behaviour)
        $type = $session->metadata->type ?? 'order';

        if (empty($orderIds)) {
            return view('payment-gateway.success', [
                'message' => 'No order IDs found in Stripe session',
                'orders' => []
            ]);
        }

        // Actual Stripe values
        $currency = strtoupper($session->currency);
        $amountPaid = $session->amount_total / 100;

        $updateData = [
            'payment_status'   => 1,
            'currency'         => $currency,
            'paid_amount'      => $amountPaid,
            'stripe_session_id' => $session->id,
            'payment_intent'   => $session->payment_intent,
        ];

        /*
        |--------------------------------------------------------------------------
        | Update the appropriate model
        |--------------------------------------------------------------------------
        */

        if ($type === 'bundle') {

            BundleOrder::whereIn('id', $orderIds)
                ->update($updateData);

        } else {

            // Old functionality remains unchanged
            GuestOrder::whereIn('id', $orderIds)
                ->update($updateData);
               $upsellResult = $this->sendUpsellPromotionIfEligible(
            $request,
            $currency,
            $amountPaid,
            $orderIds,
            $type
        );
        }

        app(OneSignalService::class)->sendToAdmins(
            '💳 Payment Received',
            "Payment of {$currency} {$amountPaid} has been received for Order(s): #" . implode(', #', $orderIds)
        );
       
        /*
        |--------------------------------------------------------------------------
        | CHECK £30 THRESHOLD AND SEND UPSELL EMAIL
        |--------------------------------------------------------------------------
        */




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

            'promo_id' => 'nullable|integer',

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
        // PROMO CODE
        // =========================

        $promoId = $validated['promo_id'] ?? null;

        $promoRecord = null;

        $promoDiscount = 0;

        $discountAmount = 0;


        if ($promoId) {

            // Find promo record
            $promoRecord = PromoCode::find($promoId);
           

            // Promo does not exist
            if (!$promoRecord) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid promo code.'
                ], 422);
            }


            // =========================
            // CHECK EXPIRY
            // =========================

            if (
                !empty($promoRecord->expired_at) &&
                now()->greaterThanOrEqualTo($promoRecord->expired_at)
            ) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Sorry, this promo code has expired.'
                ], 422);
            }


            // =========================
            // CHECK IF ALREADY USED
            // =========================

            if ((int) $promoRecord->is_used === 1) {
              
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Sorry, this promo code has already been used.'
                ], 422);
            }


            // =========================
            // GET DISCOUNT
            // =========================

            $promoDiscount = $promoRecord->discount;


            // Make sure discount is numeric
            if (!is_numeric($promoDiscount)) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid promo discount value.'
                ], 422);
            }


            // Convert to float
            $promoDiscount = (float) $promoDiscount;


            // =========================
            // VALIDATE DISCOUNT RANGE
            // =========================

            if ($promoDiscount <= 0 || $promoDiscount > 100) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid promo discount percentage.'
                ], 422);
            }
        }


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


            // =========================
            // PRODUCT SUBTOTAL
            // =========================

            $subtotal = $price * $qty;


            // Add original subtotal to total
            $total += $subtotal;


            // =========================
            // CREATE ORDER
            // =========================

            $order = GuestOrder::create([

                'product_id' =>
                    $product->id,

                'product_option' =>
                    json_encode(
                        $item['product_option'] ?? null
                    ),

                'quantity' =>
                    $qty,

                'purchase_type' =>
                    $item['purchase_type'] ?? 'default',


                'name' =>
                    $validated['name'],

                'email' =>
                    $validated['email'],

                'phone' =>
                    $validated['phone'],


                'promo_id' =>
                    $promoId,


                'address1' =>
                    $validated['address1'],

                'city' =>
                    $validated['city'],

                'postal' =>
                    $validated['postal'],

                'country' =>
                    $validated['country'],


                'lat' =>
                    $validated['lat'],

                'lng' =>
                    $validated['lng'],


                // PAYMENT STATUS
                // 0 = pending
                // 1 = paid
                'payment_status' =>
                    0,


                'user_id' =>
                    $userId,

                'guest_id' =>
                    $guestId,
            ]);


            $orderIds[] =
                $order->id;


            // =========================
            // ADDED FOR EMAIL
            // =========================

            $orderedProducts[] = [

                'order' =>
                    $order,

                'product' =>
                    $product,

                'quantity' =>
                    $qty,

                'subtotal' =>
                    $subtotal,
            ];
        }


        // =========================
        // APPLY PROMO DISCOUNT
        // =========================

        if ($promoRecord) {

            /*
            |-----------------------------------------
            | Calculate discount from FULL CART TOTAL
            |-----------------------------------------
            */

            $discountAmount =
                $total *
                ($promoDiscount / 100);


            /*
            |-----------------------------------------
            | Keep discounted amount in total
            |-----------------------------------------
            */

            $total =
                $total -
                $discountAmount;

             PromoCode::where('id', $request->promo_id)
    ->update(['is_used' => 1]);

            /*
            |-----------------------------------------
            | Prevent negative total
            |-----------------------------------------
            */

            if ($total < 0) {
                $total = 0;
            }
        }


        // =========================
        // COMMIT
        // =========================

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

            'status' =>
                true,

            'message' =>
                'Order created successfully',

            'order_ids' =>
                $orderIds,

            'total_price' =>
                round($total, 2),

            'guest_id' =>
                $guestId,

            'promo_id' =>
                $promoId,

            'promo_discount' =>
                $promoDiscount,

            'discount_amount' =>
                round($discountAmount, 2),

            'email' =>
                $orderedProducts
        ]);


        // IMPORTANT: always attach cookie properly

        if (
            $guestId &&
            !$request->cookie('guest_id')
        ) {

            $response->cookie(
                'guest_id',
                $guestId,
                60 * 24 * 365
            );
        }


        return $response;


    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([

            'status' =>
                false,

            'message' =>
                'Validation error',

            'errors' =>
                $e->errors()

        ], 422);


    } catch (\Throwable $e) {

        return response()->json([

            'status' =>
                false,

            'message' =>
                'Server error',

            'error' =>
                config('app.debug')
                    ? $e->getMessage()
                    : null

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


















    private function sendUpsellPromotionIfEligible(
    Request $request,
    string $currency,
    float $amountPaid,
    array $orderIds,
    string $type
) {
    try {

        /*
        |--------------------------------------------------------------------------
        | Convert Payment To GBP
        |--------------------------------------------------------------------------
        */

        $amountInGbp = $this->convertToGbp(
            $currency,
            $amountPaid
        );

        /*
        |--------------------------------------------------------------------------
        | Customer Must Spend MORE Than £30
        |--------------------------------------------------------------------------
        */

        if ($amountInGbp <= 30) {

            return [
                'eligible'      => false,
                'amount_paid'   => $amountPaid,
                'currency'      => $currency,
                'amount_in_gbp' => round($amountInGbp, 2),
                'email_sent'    => false,
                'message'       => 'Customer is not eligible for the upsell promotion.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Find Customer
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();

        $guestId = $request->cookie('guest_id');

        $order = null;


        /*
        |--------------------------------------------------------------------------
        | Authenticated User
        |--------------------------------------------------------------------------
        */

        if ($userId) {

            $order = GuestOrder::whereIn('id', $orderIds)
                ->where('user_id', $userId)
                ->where('payment_status', 1)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Guest User
        |--------------------------------------------------------------------------
        */

        if (!$order && $guestId) {

            $order = GuestOrder::whereIn('id', $orderIds)
                ->where('guest_id', $guestId)
                ->where('payment_status', 1)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Fallback - Find Paid Order
        |--------------------------------------------------------------------------
        */

        if (!$order) {

            $order = GuestOrder::whereIn('id', $orderIds)
                ->where('payment_status', 1)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Customer / Order Not Found
        |--------------------------------------------------------------------------
        */

        if (!$order) {

            return [
                'eligible'      => true,
                'email_sent'    => false,
                'amount_paid'   => $amountPaid,
                'currency'      => $currency,
                'amount_in_gbp' => round($amountInGbp, 2),
                'message'       => 'Customer qualified, but no paid order with a valid email was found.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Customer Email
        |--------------------------------------------------------------------------
        */

        if (empty($order->email)) {

            return [
                'eligible'      => true,
                'email_sent'    => false,
                'amount_in_gbp' => round($amountInGbp, 2),
                'message'       => 'Customer qualified, but no customer email was found.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Customer Identity
        |--------------------------------------------------------------------------
        */

        $customerUserId = $order->user_id ?? null;

        $customerGuestId = $order->guest_id ?? null;


        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING UPSELL PROMOTION
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | This must happen AFTER $order has been found.
        |
        */

        $existingPromo = PromoCode::where('order_id', $order->id)
            ->where('code', 'like', 'UPSELL-%')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Already Generated
        |--------------------------------------------------------------------------
        */

        if ($existingPromo) {

            return [
                'eligible'       => true,
                'email_sent'     => false,
                'already_sent'   => true,

                'email'          => $order->email,

                'order_id'       => $order->id,

                'user_id'        => $customerUserId,
                'guest_id'       => $customerGuestId,

                'promo_code'     => $existingPromo->code,
                'discount'       => $existingPromo->discount,
                'expires_at'     => $existingPromo->expires_at,

                'currency'       => $currency,
                'amount_paid'    => $amountPaid,
                'amount_in_gbp'  => round($amountInGbp, 2),

                'message'        => 'Upsell promotion was already generated for this order.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW 20% PROMO CODE
        |--------------------------------------------------------------------------
        */

        $promoCode = PromoCode::create([

            'order_id'   => $order->id,

            'user_id'    => $customerUserId,

            'guest_id'   => $customerGuestId,

            'code'       => 'UPSELL-' . strtoupper(
                Str::random(8)
            ),

            'discount'   => 15,

            'expires_at' => now()->addHours(24),

        ]);


        /*
        |--------------------------------------------------------------------------
        | SEND UPSELL EMAIL
        |--------------------------------------------------------------------------
        */

app(UserEmailService::class)->sendUserEmail(
    $order,
    'upsell_promotion',
    [
        'promo_code'     => $promoCode,
        'discount'       => $promoCode->discount,
        'expires_at'     => $promoCode->expires_at,
        'user_id'        => $customerUserId,
        'guest_id'       => $customerGuestId,
        'currency'       => $currency,
        'amount_paid'    => $amountPaid,
        'amount_in_gbp'  => round($amountInGbp, 2),
        'order_id'       => $order->id,
    ]
);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return [

            'eligible'       => true,

            'email_sent'     => true,

            'already_sent'   => false,

            'email'          => $order->email,

            'user_id'        => $customerUserId,

            'guest_id'       => $customerGuestId,

            'order_id'       => $order->id,

            'promo_code'     => $promoCode->code,

            'discount'       => $promoCode->discount,

            'expires_at'     => $promoCode->expires_at,

            'currency'       => $currency,

            'amount_paid'    => $amountPaid,

            'amount_in_gbp'  => round($amountInGbp, 2),

            'message'        => 'Customer qualified and upsell promotion email sent successfully.',

        ];


    } catch (\Throwable $e) {

        /*
        |--------------------------------------------------------------------------
        | EXACT ERROR
        |--------------------------------------------------------------------------
        */

        return [

            'eligible'   => true,

            'email_sent' => false,

            'error'      => $e->getMessage(),

            'file'       => $e->getFile(),

            'line'       => $e->getLine(),

        ];
    }
}


private function convertToGbp(
    string $currency,
    float $amount
): float {

    $currency = strtoupper($currency);

    /*
    |--------------------------------------------------------------------------
    | GBP
    |--------------------------------------------------------------------------
    */

    if ($currency === 'GBP') {

        return $amount;
    }


    /*
    |--------------------------------------------------------------------------
    | USD → GBP
    |--------------------------------------------------------------------------
    |
    | Example rate:
    | 1 USD = 0.79 GBP
    |
    */

    if ($currency === 'USD') {

        return $amount * 0.79;
    }


    /*
    |--------------------------------------------------------------------------
    | SAR → GBP
    |--------------------------------------------------------------------------
    |
    | Example rate:
    | 1 SAR = 0.21 GBP
    |
    */

    if ($currency === 'SAR') {

        return $amount * 0.21;
    }


    /*
    |--------------------------------------------------------------------------
    | Unsupported Currency
    |--------------------------------------------------------------------------
    */

    throw new \Exception(
        "Unsupported payment currency: {$currency}"
    );
}














  public function testUpsellPromotion(Request $request)
{
    $validated = $request->validate([
        'currency' => 'required|string|in:GBP,USD,SAR',
        'amount_paid' => 'required|numeric|min:0',
        'order_ids' => 'required|array|min:1',
        'order_ids.*' => 'required|integer',
        'type' => 'nullable|string|in:order,bundle',
    ]);

    try {

        $result = $this->sendUpsellPromotionIfEligible(
            $request,
            strtoupper($validated['currency']),
            (float) $validated['amount_paid'],
            $validated['order_ids'],
            $validated['type'] ?? 'order'
        );

        return response()->json([
            'status' => true,
            'message' => 'Upsell test completed.',
            'result' => $result,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Upsell test failed.',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}
}