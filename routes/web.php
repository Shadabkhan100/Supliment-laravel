<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;


Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/about', [ProductController::class, 'createDummyProduct']);
Route::get('/admin/add-product', [AdminWebController::class, 'getAddProduct']);
Route::get('/admin/add-category', [AdminWebController::class, 'getAddCatrgory']);