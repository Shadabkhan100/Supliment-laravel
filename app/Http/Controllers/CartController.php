<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 use App\Models\CartModel;
use App\Models\ProductsModel;
use App\Services\SupabaseStorageService;



class CartController extends Controller
{
   
public function count()
{
    if (auth()->check()) {
        $count = CartModel::where('user_id', auth()->id())->count();
    } else {
        $guestId = request()->cookie('guest_id');

        $count = CartModel::where('guest_id', $guestId)->count();
    }

    return response()->json([
        'count' => $count
    ]);
}


public function cartView()
{
    $userId = Auth::id();
   $guestId = app('request')->cookie('guest_id');

    $query = CartModel::query();

    if ($userId) {

        // AUTH USER CART
        $query->where('user_id', $userId);

    } elseif ($guestId) {

        // GUEST CART
        $query->where('guest_id', $guestId);

    } else {

        // ONLY redirect if NO user AND NO guest
        return redirect('/')->with('error', 'Cart is empty');
    }

    $cartItems = $query->get();

    $grandTotal = 0;

    $cartItems->transform(function ($item) use (&$grandTotal) {

        $product = ProductsModel::find($item->product_id);

        if ($product) {

            $product->main_image_url = $product->main_image
                ? SupabaseStorageService::getPublicUrl($product->main_image)
                : null;

            $product->gallery_images_urls = collect(
                json_decode($product->gallery_images, true) ?? []
            )->map(fn ($img) =>
                $img ? SupabaseStorageService::getPublicUrl($img) : null
            )->values()->toArray();
        }

        $item->product = $product;

        $unitPrice = (float) $item->price;
        $qty = (int) $item->quantity;

        $item->unit_price = $unitPrice;
        $item->subtotal = $unitPrice * $qty;

        $grandTotal += $item->subtotal;

        return $item;
    });

    return view('profile.cart', compact('cartItems', 'grandTotal'));
}






public function addToCart(Request $request)
{
    try {

        $userId = Auth::id();
        $guestId = null;

        // =========================
        // GET GUEST ID
        // =========================
        if (!$userId) {
            $guestId = $request->input('guest_id') ?? $request->cookie('guest_id');

            if (!$guestId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Guest session not found. Please refresh page.'
                ], 401);
            }
        }

        // =========================
        // VALIDATION
        // =========================
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'purchase_type' => 'required',
            'option' => 'nullable|array'
        ]);

        // =========================
        // GET PRODUCT
        // =========================
        $product = ProductsModel::findOrFail($request->product_id);

        // =========================
        // OPTION PRICE
        // =========================
        $option = $request->option ?? [];

        $basePrice = $option['price'] ?? null;

        if (!$basePrice) {
            $basePrice = $product->price;
        }

        if ($request->purchase_type === 'subscribe') {
            $basePrice -= ($basePrice * 20 / 100);
        }

        // =========================
        // CREATE CART
        // =========================
        $cart = CartModel::create([
            'user_id' => $userId,
            'guest_id' => $guestId,
            'product_id' => $product->id,
            'option' => $option,
            'quantity' => $request->quantity,
            'purchase_type' => $request->purchase_type,
            'price' => $basePrice,
        ]);

        $cartCountQuery = CartModel::query();

        if ($userId) {
            $cartCountQuery->where('user_id', $userId);
        } else {
            $cartCountQuery->where('guest_id', $guestId);
        }

        return response()->json([
            'status' => true,
            'guest_id_debug' => $guestId,
            'request_cookie_guest_id' => $request->cookie('guest_id'),
            'request_input_guest_id' => $request->input('guest_id'),
            'cart_id' => $cart->id,
            'price_used' => $basePrice,
            'message' => 'Added to cart successfully!',
            'cart_count' => $cartCountQuery->count()
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}









public function getCartItemById($id)
{
    $item = CartModel::with(['product', 'product.deal'])->findOrFail($id);

    $product = $item->product;
    $deal = $product->deal ?? null;

    // =========================
    // FORMAT PRODUCT IMAGES + DATA
    // =========================
    if ($product) {

        $product->main_image = $product->main_image
            ? SupabaseStorageService::getPublicUrl($product->main_image)
            : null;

        $product->gallery_images = collect(json_decode($product->gallery_images, true) ?? [])
            ->map(fn ($img) => $img ? SupabaseStorageService::getPublicUrl($img) : null)
            ->values()
            ->toArray();

        $product->weights = json_decode($product->weights, true) ?? [];
        $product->tags = json_decode($product->tags, true) ?? [];
        $product->options = json_decode($product->options, true) ?? [];
    }
    // =========================
    // DEAL IMAGE
    // =========================
    if ($deal && !empty($deal->image)) {
        $deal->image = SupabaseStorageService::getPublicUrl($deal->image);
    }

    // =========================
    // OVERRIDE PRICE WITH OPTION PRICE
    // =========================
    $option = $item->option ?? null;

    if ($product && $option && isset($option['price'])) {

        // replace product price with option price
        $product->price = $option['price'];
    }

    return response()->json([
        'option'  => $item->option,
        'cart_id' => $item->id,
        'qty'     => $item->quantity,
        'product' => $product,
        'deal'    => $deal,
    ]);
}








public function deleteCartItem($id)
{
    $item = CartModel::find($id);

    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    $item->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted successfully'
    ]);
}
  
   
}