<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Services\SupabaseStorageService;

class ProductController extends Controller
{
    // =========================
    // CREATE PRODUCT
    // =========================
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products_models,sku',
            'category_id' => 'required|numeric|min:0',
            'deal_id' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weights' => 'nullable|array',
              'weights' => 'nullable|array',
            'weights.*' => 'string',
           'tags.*' => 'string',
        ]);

        // =========================
        // MAIN IMAGE (SUPABASE)
        // =========================
        $mainImagePath = null;

        if ($request->hasFile('main_image')) {
            $mainImagePath = SupabaseStorageService::upload(
                $request->file('main_image'),
                'products/main'
            );
        }

        // =========================
        // GALLERY IMAGES (SUPABASE)
        // =========================
        $galleryPaths = [];

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = SupabaseStorageService::upload(
                    $file,
                    'products/gallery'
                );
            }
        }

        // =========================
        // SAVE PRODUCT
        // =========================
        $product = ProductsModel::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'sku' => $validated['sku'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'deal_id' => $validated['deal_id'],
            'old_price' => $validated['old_price'] ?? null,
            'stock' => $validated['stock'],
            'weights' => json_encode($validated['weights'] ?? []),
             'tags' => json_encode($validated['tags'] ?? []),

            'main_image' => $mainImagePath,
            'gallery_images' => json_encode($galleryPaths),
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $this->formatProduct(
                $product,
                CategoriesModel::pluck('name', 'id')
            )
        ], 201);
    }
public function editPage($id)
{
    $product = ProductsModel::findOrFail($id);

    $categories = CategoriesModel::pluck('name', 'id');

    $formattedProduct = $this->formatProduct($product, $categories);
 return view('admin.editProductPage', [
        'product' => $formattedProduct
    ]);
    
}
    // =========================
    // GET ALL PRODUCTS
    // =========================
    public function getAllProduct()
    {
        $products = ProductsModel::all();
        $categories = CategoriesModel::pluck('name', 'id');

        return response()->json([
            'message' => 'Products fetched successfully',
            'count' => $products->count(),
            'data' => $products->map(function ($p) use ($categories) {
                return $this->formatProduct($p, $categories);
            })
        ]);
    }

    // =========================
    // FORMAT PRODUCT RESPONSE
    // =========================
    private function formatProduct($product, $categories = null)
    {
        $categories = $categories ?? CategoriesModel::pluck('name', 'id');

        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'sku' => $product->sku,
            'price' => $product->price,
            'old_price' => $product->old_price,
            'stock' => $product->stock,
             'category_id' => $product->category_id,
           'deal_id' => $product->deal_id,
            'category_name' => $categories[$product->category_id] ?? 'Uncategorized',
            'weights' => json_decode($product->weights, true) ?? [],
            'tags' => json_decode($product->tags, true) ?? [],


            // =========================
            // SUPABASE IMAGE URLS
            // =========================
            'main_image' => $product->main_image
                ? SupabaseStorageService::getPublicUrl($product->main_image)
                : null,

            'gallery_images' => collect(json_decode($product->gallery_images, true) ?? [])
                ->map(fn ($img) => $img ? SupabaseStorageService::getPublicUrl($img) : null)
                ->values()
                ->toArray(),
        ];
    }

    // =========================
    // CREATE CATEGORY
    // =========================
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories_models,name',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = SupabaseStorageService::upload(
            $request->file('image'),
            'categories'
        );

        $category = CategoriesModel::create([
            'name' => $validated['name'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => SupabaseStorageService::getPublicUrl($category->image),
            ]
        ], 201);
    }

    // =========================
    // GET CATEGORIES
    // =========================
    public function getCategories(Request $request)
    {
      $categories = CategoriesModel::withCount('products')
        ->paginate(10);

        $categories->getCollection()->transform(function ($category) {
            $category->image = $category->image
                ? SupabaseStorageService::getPublicUrl($category->image)
                : null;

            return $category;
        });

        return response()->json([
            'message' => 'Categories fetched successfully',
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'per_page' => $categories->perPage(),
            'total' => $categories->total(),
            'data' => $categories->items(),
        ]);
    }

    // =========================
    // DELETE PRODUCT
    // =========================
    public function deleteProduct($id)
    {
        $product = ProductsModel::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'status' => true
        ]);
    }

    // =========================
    // DELETE CATEGORY
    // =========================
    public function deleteCategory($id)
    {
        $category = CategoriesModel::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
            'status' => true
        ]);
    }










   public function updateProduct(Request $request, $id)
{
    $product = ProductsModel::findOrFail($id);

    // =========================
    // VALIDATION
    // =========================
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sku' => 'required|string|unique:products_models,sku,' . $id,
        'category_id' => 'required|numeric|min:0',
        'deal_id' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'old_price' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'weights' => 'nullable|array',
        'tags' => 'nullable|array',
        'weights.*' => 'string',
        'tags.*' => 'string',
    ]);

    // =========================
    // MAIN IMAGE (ONLY IF NEW UPLOADED)
    // =========================
    $mainImagePath = $product->main_image;

    if ($request->hasFile('main_image')) {
        $mainImagePath = SupabaseStorageService::upload(
            $request->file('main_image'),
            'products/main'
        );
    }

    // =========================
    // GALLERY IMAGES (APPEND OR REPLACE)
    // =========================
    $galleryPaths = json_decode($product->gallery_images, true) ?? [];

    if ($request->hasFile('gallery_images')) {

        $galleryPaths = []; // reset if replacing (IMPORTANT)

        foreach ($request->file('gallery_images') as $file) {
            $galleryPaths[] = SupabaseStorageService::upload(
                $file,
                'products/gallery'
            );
        }
    }

    // =========================
    // UPDATE PRODUCT
    // =========================
    $product->update([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'sku' => $validated['sku'],
        'price' => $validated['price'],
        'old_price' => $validated['old_price'] ?? null,
        'stock' => $validated['stock'],
        'category_id' => $validated['category_id'],
        'deal_id' => $validated['deal_id'],

        'weights' => json_encode($validated['weights'] ?? []),
        'tags' => json_encode($validated['tags'] ?? []),

        'main_image' => $mainImagePath,
        'gallery_images' => json_encode($galleryPaths),
    ]);

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $this->formatProduct(
            $product->fresh(),
            CategoriesModel::pluck('name', 'id')
        )
    ]);
}
}