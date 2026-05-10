<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class PageSettingController extends Controller
{
    // CREATE / UPDATE PAGE SETTINGS
   public function save(Request $request)
{
    $validated = $request->validate([
        'description' => 'nullable|string',
        'home_banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $bannerPath = null;

    if ($request->hasFile('home_banner')) {
        $image = $request->file('home_banner');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('banners'), $imageName);

        $bannerPath = 'banners/' . $imageName;
    }

    // ❗ CREATE NEW RECORD EVERY TIME (NOT UPDATE)
    $setting = PageSetting::create([
        'description' => $validated['description'] ?? null,
        'home_banner' => $bannerPath,
    ]);

    return response()->json([
        'message' => 'Banner added successfully',
        'data' => [
            'id' => $setting->id,
            'description' => $setting->description,
            'home_banner' => $setting->home_banner ? asset($setting->home_banner) : null,
        ]
    ]);
}
    // GET SETTINGS
    public function get()
{
    $settings = PageSetting::latest()->get();

    return response()->json([
        'message' => 'Page settings fetched successfully',
        'data' => $settings->map(function ($setting) {
            return [
                'id' => $setting->id,
                'description' => $setting->description,
                'home_banner' => $setting->home_banner
                    ? asset($setting->home_banner)
                    : null,
            ];
        })
    ]);
}
}