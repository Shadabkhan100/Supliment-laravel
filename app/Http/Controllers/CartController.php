<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 use App\Models\CartModel;
use App\Models\ProductsModel;
use App\Services\SupabaseStorageService;



class CartController extends Controller
{
   


public function cartView()
{
    // user must be logged in
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Please login first');
    }

    $userId = Auth::id();

    // get cart items of user
    $cartItems = CartModel::where('user_id', $userId)->get();

    // attach product details manually
    $cartItems->transform(function ($item) {

        $product = ProductsModel::find($item->product_id);

        if ($product) {

            // Supabase main image URL
            $product->main_image_url = $product->main_image
                ? SupabaseStorageService::getPublicUrl($product->main_image)
                : null;

            // Supabase gallery URLs
            $product->gallery_images_urls = collect(
                json_decode($product->gallery_images, true) ?? []
            )->map(fn ($img) =>
                $img ? SupabaseStorageService::getPublicUrl($img) : null
            )->values()->toArray();
        }

        $item->product = $product;

        return $item;
    });

    return view('profile.cart', compact('cartItems'));

}  
public function addToCart(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'status' => false,
            'message' => 'Please login first to add items to cart.'
        ], 401);
    }

    $request->validate([
        'product_id' => 'required',
        'quantity' => 'required|integer|min:1',
        'purchase_type' => 'required',
        'option' => 'required'
    ]);

    $option = $request->option;

    // calculate price safely
    $basePrice = $option['price'] ?? 0;

    if ($request->purchase_type === 'subscribe') {
        $basePrice = $basePrice - ($basePrice * 20 / 100);
    }

    $cart = CartModel::create([
        'user_id' => Auth::id(),
        'product_id' => $request->product_id,
        'option' => $option,
        'quantity' => $request->quantity,
        'purchase_type' => $request->purchase_type,
        'price' => $basePrice,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Product added to cart successfully!',
        'cart_count' => CartModel::where('user_id', Auth::id())->count(),
    ]);
}





public function getCartItemById($id)
{
    $item = CartModel::with(['product', 'product.deal'])->findOrFail($id);

    $product = $item->product;
    $deal = $product->deal ?? null;

    // =========================
    // ONLY FORMAT IMAGES (PRODUCT)
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
    // ONLY FORMAT DEAL IMAGE (if exists)
    // =========================
    if ($deal && !empty($deal->image)) {
        $deal->image = SupabaseStorageService::getPublicUrl($deal->image);
    }

    return response()->json([
         'option' => $item->option,
        'cart_id' => $item->id,
        'qty' => $item->quantity,
        'product' => $product,
        'deal' => $deal,
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