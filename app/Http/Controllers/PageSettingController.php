<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PageSetting;
use App\Services\SupabaseStorageService;
class PageSettingController extends Controller
{

public function save(Request $request)
{
    $validated = $request->validate([
        'description' => 'nullable|string',
        'home_banner' => 'nullable|image|max:2048',
    ]);

    $bannerUrl = null;

    // UPLOAD USING SERVICE
    if ($request->hasFile('home_banner')) {

        $path = SupabaseStorageService::upload(
            $request->file('home_banner'),
            'slimza-images'
        );

        // STORE FULL PUBLIC URL
        $bannerUrl = SupabaseStorageService::getPublicUrl($path);
    }

    // SAVE IN DATABASE
    $setting = PageSetting::create([
        'description' => $validated['description'] ?? null,
        'home_banner' => $bannerUrl,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Banner saved successfully',
        'data' => $setting
    ]);
}
    public function get()
{
    $settings = PageSetting::latest()->get();

    return response()->json([
        'message' => 'Page settings fetched successfully',
        'data' => $settings->map(function ($setting) {
            return [
                'id' => $setting->id,
                'description' => $setting->description,
                'home_banner' => $setting->home_banner,
            ];
        })
    ]);
}
}