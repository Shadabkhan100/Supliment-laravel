<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;


Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/railway-test', function () {
    return 'LATEST VERSION 999';
});
Route::get('/about', [ProductController::class, 'createDummyProduct']);
Route::get('/admin/add-product', [AdminWebController::class, 'getAddProduct']);
Route::get('/admin/add-category', [AdminWebController::class, 'getAddCatrgory']);
Route::get('/admin/update-banner', [AdminWebController::class, 'getUpdateBannerView']);
Route::get('/check-storage', function () {

    return [

        'storage_exists' => file_exists(storage_path('app/public/categories')),

        'public_storage_exists' => file_exists(public_path('storage')),

        'files' => Storage::disk('public')->files('categories'),

    ];

});