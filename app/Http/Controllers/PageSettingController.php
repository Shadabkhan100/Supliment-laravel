<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PageSetting;

class PageSettingController extends Controller
{

public function save(Request $request)
{
    $validated = $request->validate([
        'description' => 'nullable|string',
        'home_banner' => 'nullable|image|max:2048',
    ]);

    $bannerUrl = null;

    // UPLOAD IMAGE TO SUPABASE
    if ($request->hasFile('home_banner')) {

        $file = $request->file('home_banner');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => $file->getMimeType(),
        ])
        ->withBody(
            file_get_contents($file),
            $file->getMimeType()
        )
        ->post(
            $supabaseUrl . '/storage/v1/object/slimza-images/' . $fileName
        );

        // SUCCESS
        if ($response->successful()) {

            $bannerUrl =
                $supabaseUrl .
                '/storage/v1/object/public/slimza-images/' .
                $fileName;
        } else {

            return response()->json([
                'message' => 'Upload failed',
                'error' => $response->body()
            ], 500);
        }
    }

    // SAVE IN DATABASE
    $setting = PageSetting::create([
        'description' => $validated['description'] ?? null,
        'home_banner' => $bannerUrl,
    ]);

    return response()->json([
        'message' => 'Banner saved successfully',
        'data' => $setting
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
                'home_banner' => $setting->home_banner,
            ];
        })
    ]);
}
}