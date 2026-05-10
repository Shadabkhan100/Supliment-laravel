<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products_models,sku',
            'category_id' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weights' => 'nullable|array',
            'weights.*' => 'string',
        ]);

        // MAIN IMAGE
        $mainImagePath = null;

        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')
                ->store('products/main', 'public');
        }

        // GALLERY IMAGES
        $galleryPaths = [];

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = $file->store('products/gallery', 'public');
            }
        }

        $product = ProductsModel::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'sku' => $validated['sku'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'old_price' => $validated['old_price'] ?? null,
            'stock' => $validated['stock'],
            'weights' => json_encode($validated['weights'] ?? []),
            'main_image' => $mainImagePath,
            'gallery_images' => json_encode($galleryPaths),
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $this->formatProduct($product)
        ], 201);
    }

 public function getAllProduct()
{
    $products = ProductsModel::latest()->get();

    // preload categories (avoids N+1 query issue)
    $categories = CategoriesModel::pluck('name', 'id');

    return response()->json([
        'message' => 'Products fetched successfully',
        'count' => $products->count(),
        'data' => $products->map(function ($p) use ($categories) {
            return $this->formatProduct($p, $categories);
        })
    ]);
}

    // 🔥 CLEAN FORMATTER (IMPORTANT IMPROVEMENT)
   private function formatProduct($product, $categories)
{
    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'sku' => $product->sku,
        'price' => $product->price,
        'old_price' => $product->old_price,
        'stock' => $product->stock,

        // ⭐ CATEGORY NAME ADDED HERE
        'category_id' => $product->category_id,
        'category_name' => $categories[$product->category_id] ?? 'Uncategorized',

        // ARRAY SAFE
        'weights' => json_decode($product->weights, true) ?? [],

        // MAIN IMAGE
        'main_image' => $product->main_image
            ? asset('storage/' . $product->main_image)
            : null,

        // GALLERY IMAGES
        'gallery_images' => collect(json_decode($product->gallery_images, true) ?? [])
            ->map(fn ($img) => $img ? asset('storage/' . $img) : null)
            ->values()
            ->toArray(),
    ];
}






    public function createCategory(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories_models,name',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image'))
    {
       $image = $request->file('image');

$imageName = time() . '_' . $image->getClientOriginalName();

$image->move(public_path('categories'), $imageName);

$imagePath = 'categories/' . $imageName;
    }
    // CREATE CATEGORY
    $category = CategoriesModel::create([

        'name' => $validated['name'],

        'image' => $imagePath,

    ]);

    // RESPONSE
    return response()->json([

        'success' => true,

        'message' => 'Category created successfully',

        'data' => [

            'id' => $category->id,

            'name' => $category->name,

            'image' => $category->image
                ? url('storage/' . $category->image)
                : null,

        ]

    ], 201);
}



     public function getCategories(Request $request)
{
    $categories = CategoriesModel::latest()
        ->withCount('products')
        ->paginate(10);

    // FORMAT IMAGE URL
    $categories->getCollection()->transform(function ($category) {
$baseUrl = url('/');

$category->image = $category->image
    ? $baseUrl . '/' . ltrim($category->image, '/')
    : null;

        return $category;
    });

    // RETURN JSON RESPONSE
    return response()->json([
        'message' => 'Categories fetched successfully',
        'current_page' => $categories->currentPage(),
        'last_page' => $categories->lastPage(),
        'per_page' => $categories->perPage(),
        'total' => $categories->total(),
        'data' => $categories->items(),
    ]);
}




   public function deleteProduct($id)
{
    $product = ProductsModel::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    // Optional: delete images if stored locally
    // Storage::delete($product->main_image);

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully',
        'status' => true
    ]);
}

   public function deleteCategory($id)
{
    $category = CategoriesModel::find($id);

    if (!$category) {
        return response()->json([
            'message' => 'Category not found'
        ], 404);
    }

    // Optional: delete images if stored locally
    // Storage::delete($category->image);

    $category->delete();

    return response()->json([
        'message' => 'Category deleted successfully',
        'status' => true
    ]);
}
   
}