<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;

// Simple test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working fine!'
    ]);
});
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::get('/get-all-product', [ProductController::class, 'getAllProduct']);
Route::post('/create-category', [ProductController::class, 'createCategory']);
Route::get('/categories', [ProductController::class, 'getCategories']);
Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
Route::delete('/delete-category/{id}', [ProductController::class, 'deleteCategory']);