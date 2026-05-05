<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;

Route::get('/', [WebRoutController::class, 'getHome']);