<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class OneSignalController extends Controller
{
    

public function save(Request $request)
{
    auth()->user()->update([

        'onesignal_subscription_id' => $request->subscription_id

    ]);

    return response()->json([
        'success' => true
    ]);
}
}
