<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Simple test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working fine!'
    ]);
});

