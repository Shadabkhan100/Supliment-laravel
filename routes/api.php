<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\DealsManagement;
use App\Http\Controllers\PageSettingController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\FutureProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\TestimonialsController;

// Simple test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working fine!'
    ]);
});
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::post('/update-product/{id}', [ProductController::class, 'updateProduct']);
Route::get('/get-all-product', [ProductController::class, 'getAllProduct']);
Route::post('/create-category', [ProductController::class, 'createCategory']);
Route::get('/categories', [ProductController::class, 'getCategories']);
Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
Route::delete('/delete-category/{id}', [ProductController::class, 'deleteCategory']);
Route::post('/page-settings', [PageSettingController::class, 'save']);
Route::get('/page-settings', [PageSettingController::class, 'get']);



Route::get('/cart-item/{id}', [CartController::class, 'getCartItemById']);
Route::delete('/cart/delete/{id}', [CartController::class, 'deleteCartItem']);

Route::get('/testimonials', [TestimonialsController::class, 'index']);
Route::post('/create-testimonials', [TestimonialsController::class, 'store']);
Route::delete('/testimonials/{id}', [TestimonialsController::class, 'destroy']);

Route::post('/signup-user', [AuthController::class,'registerUser']);


Route::prefix('deals')->group(function () {

    Route::get('/', [DealsManagement::class, 'index']);

    Route::post('/create-deal', [DealsManagement::class, 'store']);

    Route::get('/{id}', [DealsManagement::class, 'show']);

    Route::post('/update/{id}', [DealsManagement::class, 'update']);

    Route::delete('/{id}', [DealsManagement::class, 'destroy']);
});


Route::prefix('blogs')->group(function () {
Route::get('/', [BlogsController::class, 'index']);

Route::post('/create-blogs', [BlogsController::class, 'store']);

Route::get('/get-blogs/{id}', [BlogsController::class, 'show']);

Route::post('/update-blogs/{id}', [BlogsController::class, 'update']);

Route::delete('/delete-blogs/{id}', [BlogsController::class, 'destroy']);
});

Route::get('/get-future-products', [FutureProductController::class, 'index']);
Route::post('/future-products', [FutureProductController::class, 'store']);
Route::delete('/future-products/{id}', [FutureProductController::class, 'destroy']);
