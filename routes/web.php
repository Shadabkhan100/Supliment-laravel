<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;

Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/about', [WebRoutController::class, 'getAbout']);