<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Services\SupabaseStorageService;
use Illuminate\Validation\Rule;


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

        // arrays
        'weights' => 'nullable|array',
        'weights.*' => 'string',

        'tags' => 'nullable|array',
        'tags.*' => 'string',

        'options' => 'nullable|array',

        // text fields
        'supplement_facts' => 'nullable|string',
        'how_to_use' => 'nullable|string',
        'shipping_info' => 'nullable|string',
          'ingredients' => 'nullable|string',           
        'halal_certification' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // =========================
    // MAIN IMAGE
    // =========================
    $mainImagePath = null;

    if ($request->hasFile('main_image')) {
        $mainImagePath = SupabaseStorageService::upload(
            $request->file('main_image'),
            'products/main'
        );
    }

    // =========================
    // GALLERY IMAGES
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
    // HALAL CERTIFICATION IMAGE
    // =========================
    $halalCertPath = null;

    if ($request->hasFile('halal_certification')) {
        $halalCertPath = SupabaseStorageService::upload(
            $request->file('halal_certification'),
            'products/halal'
        );
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
        'options' => json_encode($validated['options'] ?? []),

        // NEW TEXT FIELD
        'supplement_facts' => $validated['supplement_facts'] ?? null,
        'how_to_use' => $validated['how_to_use'] ?? null,
        'shipping_info' => $validated['shipping_info'] ?? null,
         'ingredients' => $validated['ingredients'] ?? null,   // ✅ ADDED HERE

        // IMAGES
        'main_image' => $mainImagePath,
        'gallery_images' => json_encode($galleryPaths),
        'halal_certification' => $halalCertPath,
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
        'ingredients' => $product->ingredients,

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
    // =========================
    // CREATE CATEGORY
    // =========================
    public function createCategory(Request $request)
    {
       $validated = $request->validate([
    'name' => 'required|string|max:255|unique:categories_models,name',
    'index_no' => 'required|integer|unique:categories_models,index_no',
    'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
]);

        $imagePath = SupabaseStorageService::upload(
            $request->file('image'),
            'categories'
        );

        $category = CategoriesModel::create([
            'name' => $validated['name'],
            'image' => $imagePath,
                'index_no' => $validated['index_no'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => SupabaseStorageService::getPublicUrl($category->image),
                 'index_no' => $category->index_no,

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
        'options' => 'nullable|array',
          'ingredients' => 'nullable|string',


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
    // HALAL CERTIFICATION (NEW - SAFE ADDITION)
    // =========================
    $halalPath = $product->halal_certification;

    if ($request->hasFile('halal_certification')) {
        $halalPath = SupabaseStorageService::upload(
            $request->file('halal_certification'),
            'products/halal'
        );
    }

    // =========================
    // GALLERY IMAGES
    // =========================
$galleryPaths = [];

if ($request->filled('existing_gallery_images')) {
    $decoded = json_decode($request->existing_gallery_images, true);

    if (is_array($decoded)) {
        $galleryPaths = array_values(array_filter($decoded));
    }
}

// ALWAYS ensure ONLY paths are stored
$galleryPaths = array_map(function ($path) {
    // remove full URL if accidentally sent
    return str_replace(
        'https://dulladbjjuutgcgyliou.supabase.co/storage/v1/object/public/slimza-images/',
        '',
        $path
    );
}, $galleryPaths);

if (empty($galleryPaths)) {
    $galleryPaths = json_decode($product->gallery_images, true) ?? [];
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
        'options' => json_encode($validated['options'] ?? []),
        'main_image' => $mainImagePath,
        'gallery_images' => json_encode($galleryPaths),

        // =========================
        // NEW FIELDS ADDED (SAFE)
        // =========================
        'shipping_info' => $request->shipping_info,
        'supplement_facts' => $request->supplement_facts,
        'how_to_use' => $request->how_to_use,
        'halal_certification' => $halalPath,
          'ingredients' => $request->ingredients,
          
    ]);

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $this->formatProduct(
            $product->fresh(),
            CategoriesModel::pluck('name', 'id')
        )
    ]);
}



private function formatImage($path)
{
    if (!$path) return null;

    // already full URL → return as-is
    if (str_starts_with($path, 'http')) {
        return $path;
    }

    return rtrim(env('SUPABASE_URL'), '/')
        . '/storage/v1/object/public/slimza-images/'
        . ltrim($path, '/');
}









    public function updateCategory(Request $request, $id)
{
    $category = CategoriesModel::findOrFail($id);

    $validated = $request->validate([
    'name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('categories_models', 'name')->ignore($id),
    ],

  

    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
]);

    if ($request->hasFile('image')) {
        $imagePath = SupabaseStorageService::upload(
            $request->file('image'),
            'categories'
        );

        $category->image = $imagePath;
    }

    $category->name = $validated['name'];

    $category->save();

    return response()->json([
        'success' => true,
        'message' => 'Category updated successfully',
        'data' => $category
    ]);
}






public function getProductById($id)
{
    $product = ProductsModel::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found',
            'status' => false
        ], 404);
    }

    $categories = CategoriesModel::pluck('name', 'id');

    return response()->json([
        'message' => 'Product fetched successfully',
        'status' => true,
        'data' => $this->formatProduct($product, $categories)
    ]);
}
}