<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\BundleOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BundleOrderMail;
use App\Services\UserEmailService;


class BundleOrders extends Controller
{
  

public function createBundleOrder(Request $request)
{
    try {

        $customer = $request->input('customer', []);
        $bundle = $request->input('bundle', []);
        $summary = $bundle['summary'] ?? [];

      
 



         $userId = null;
$guestId = null;

if (Auth::check()) {

    $userId = Auth::id();

} else {

    $guestId = $request->cookie('guest_id');

    if (!$guestId) {

        $guestId = 'gst_' . Str::random(24);

        Cookie::queue(
            Cookie::make(
                'guest_id',
                $guestId,
                60 * 24 * 365 // 1 year
            )
        );
    }
}




        $bundleOrder = BundleOrder::create([

            // User information
            'user_id' => $userId,
            'guest_id' => $guestId,

            // Customer information
            'first_name' => $customer['first_name'] ?? null,
            'last_name' => $customer['last_name'] ?? null,
            'email' => $customer['email'] ?? null,
            'phone' => $customer['phone'] ?? null,
            'company' => $customer['company'] ?? null,
            'address_1' => $customer['address_1'] ?? null,
            'address_2' => $customer['address_2'] ?? null,
            'city' => $customer['city'] ?? null,
            'state' => $customer['state'] ?? null,
            'postcode' => $customer['postcode'] ?? null,
            'country' => $customer['country'] ?? null,
            'notes' => $customer['notes'] ?? null,
            'lat' => $customer['lat'] ?? null,
            'lng' => $customer['lng'] ?? null,
            'payment_status' => 0,
             'order_status' => 'Pending',
            // Bundle information
            'products' => $bundle['products'] ?? [],
            'item_count' => $summary['item_count'] ?? 0,
            'subtotal' => $summary['subtotal'] ?? 0,
            'discount_percentage' => $summary['discount_percentage'] ?? 0,
            'discount_amount' => $summary['discount_amount'] ?? 0,
            'total' => $summary['total'] ?? 0,
        ]);
      

$user = (object) [
    'email' => $bundleOrder->email
];

app(UserEmailService::class)->sendUserEmail(
    $user,
    'bundle_order',
    [
        'bundle_order' => $bundleOrder
    ]
);

        return response()->json([
            'success' => true,
            'message' => 'Bundle order created successfully.',
            'order_id' => $bundleOrder->id,
             'type' => 'type',
            'data' => $bundleOrder
        ], 201);

    } catch (Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Unable to create the bundle order.',
            'error' => [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ]
        ], 500);
    }
}
}