<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PageSetting;
use App\Services\SupabaseStorageService;
use App\Models\WebModel;
use Illuminate\Support\Facades\Validator;

class PageSettingController extends Controller
{

   public function webSettingUpdate(Request $request)
{
    try {

        $validator = Validator::make($request->all(), [

            'website_title'     => 'required|string|max:255',
            'meta_description'  => 'nullable|string',
            'promotion_text'    => 'nullable|string|max:255',
            'support_email'     => 'required|email|max:255',
            'canonical_url'     => 'required|url|max:255',

            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon'           => 'nullable|image|mimes:jpg,jpeg,png,ico,svg|max:1024',
            'og_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);

        }

        // Get existing settings or create new
        $setting = WebModel::first();

        if (!$setting) {
            $setting = new WebModel();
        }

        $setting->website_title    = $request->website_title;
        $setting->meta_description = $request->meta_description;
        $setting->promotion_text   = $request->promotion_text;
        $setting->support_email    = $request->support_email;
        $setting->canonical_url    = $request->canonical_url;

        /*
        |--------------------------------------------------------------------------
        | Upload Images to Supabase
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            $setting->logo = SupabaseStorageService::upload(
                $request->file('logo'),
                'website/logo'
            );
        }

        if ($request->hasFile('favicon')) {

            $setting->favicon = SupabaseStorageService::upload(
                $request->file('favicon'),
                'website/favicon'
            );
        }

        if ($request->hasFile('og_image')) {

            $setting->og_image = SupabaseStorageService::upload(
                $request->file('og_image'),
                'website/og-image'
            );
        }

        $setting->save();

        return response()->json([
            'status'  => true,
            'message' => 'Website settings updated successfully.'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong while updating website settings.',
            'error'   => config('app.debug') ? $e->getMessage() : null
        ], 500);

    }
}







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




    public function updatedBanner(Request $request, $id)
{
    $setting = PageSetting::find($id);

    if (!$setting) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $validated = $request->validate([
        'description' => 'nullable|string',
        'home_banner' => 'nullable|image|max:2048',
    ]);

    // update description
    $setting->description = $validated['description'] ?? $setting->description;

    // if new image uploaded → replace old one
    if ($request->hasFile('home_banner')) {

        $path = SupabaseStorageService::upload(
            $request->file('home_banner'),
            'slimza-images'
        );

        $setting->home_banner = SupabaseStorageService::getPublicUrl($path);
    }

    $setting->save();

    return response()->json([
        'status' => true,
        'message' => 'Banner updated successfully',
        'data' => $setting
    ]);
}











   public function deleteBanner($id)
{
    $setting = PageSetting::find($id);

    if (!$setting) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    // Optional: delete image from Supabase if needed
    // if ($setting->home_banner) {
    //     SupabaseStorageService::delete($setting->home_banner);
    // }

    $setting->delete();

    return response()->json([
        'status' => true,
        'message' => 'Banner deleted successfully'
    ]);
}
}