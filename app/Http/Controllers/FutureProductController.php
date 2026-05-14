<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FutureProduct;
use Illuminate\Http\Request;
use App\Services\SupabaseStorageService;

class FutureProductController extends Controller
{
    /**
     * GET API
     */
    public function index()
    {
        $futureProducts = FutureProduct::where('status', true)
            ->orderBy('id', 'DESC')
            ->get();

        $futureProducts = $futureProducts->map(function ($product) {

            $product->image = $product->image
                ? SupabaseStorageService::getPublicUrl($product->image)
                : null;

            return $product;
        });

        return response()->json([
            'status' => true,
            'message' => 'Future products fetched successfully',
            'data' => $futureProducts
        ]);
    }

    /**
     * STORE API
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'validity' => 'nullable|date',
            'status' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = SupabaseStorageService::upload(
                $request->file('image'),
                'future-products'
            );
        }

        $futureProduct = FutureProduct::create([
            'title' => $request->title,
            'image' => $imagePath,
            'validity' => $request->validity,
            'status' => $request->status ?? true,
        ]);

        $futureProduct->image = $futureProduct->image
            ? SupabaseStorageService::getPublicUrl($futureProduct->image)
            : null;

        return response()->json([
            'status' => true,
            'message' => 'Future product created successfully',
            'data' => $futureProduct
        ]);
    }


public function destroy($id)
{
    $product = FutureProduct::findOrFail($id);

    $product->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
}
}