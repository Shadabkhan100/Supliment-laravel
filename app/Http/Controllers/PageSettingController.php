<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PageSetting;
use App\Services\SupabaseStorageService;
use App\Models\WebModel;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscribers;
use App\Services\UserEmailService;



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

        /*
        |--------------------------------------------------------------------------
        | Get Existing Settings
        |--------------------------------------------------------------------------
        */

        $setting = WebModel::first();

        if (!$setting) {
            $setting = new WebModel();
        }

        /*
        |--------------------------------------------------------------------------
        | Get OLD promotion before changing anything
        |--------------------------------------------------------------------------
        */

        $oldPromotionText = $setting->promotion_text;

        /*
        |--------------------------------------------------------------------------
        | Update Settings
        |--------------------------------------------------------------------------
        */

        $setting->website_title    = $request->website_title;
        $setting->meta_description = $request->meta_description;
        $setting->promotion_text   = $request->promotion_text;
        $setting->support_email    = $request->support_email;
        $setting->canonical_url    = $request->canonical_url;

        /*
        |--------------------------------------------------------------------------
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            $setting->logo = SupabaseStorageService::upload(
                $request->file('logo'),
                'website/logo'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Favicon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('favicon')) {

            $setting->favicon = SupabaseStorageService::upload(
                $request->file('favicon'),
                'website/favicon'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload OG Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('og_image')) {

            $setting->og_image = SupabaseStorageService::upload(
                $request->file('og_image'),
                'website/og-image'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Settings
        |--------------------------------------------------------------------------
        */

        $setting->save();

        /*
        |--------------------------------------------------------------------------
        | NEW Promotion Text
        |--------------------------------------------------------------------------
        */

        $newPromotionText = $setting->promotion_text;

        /*
        |--------------------------------------------------------------------------
        | Check Whether Promotion Changed
        |--------------------------------------------------------------------------
        */

        $promotionChanged = trim((string) $oldPromotionText)
            !== trim((string) $newPromotionText);

        /*
        |--------------------------------------------------------------------------
        | If Promotion Changed
        |--------------------------------------------------------------------------
        */

        if ($promotionChanged && !empty(trim((string) $newPromotionText))) {

            /*
            |--------------------------------------------------------------------------
            | Get Subscribers
            |--------------------------------------------------------------------------
            */

            $subscribers = Subscribers::whereNotNull('email')
                ->where('email', '!=', '')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | No Subscribers
            |--------------------------------------------------------------------------
            */

            if ($subscribers->isEmpty()) {

                return response()->json([
                    'status'  => true,
                    'message' => 'Settings updated, but no subscribers were found.',
                    'debug' => [
                        'old_promotion' => $oldPromotionText,
                        'new_promotion' => $newPromotionText,
                        'promotion_changed' => true,
                        'subscriber_count' => 0,
                    ]
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Send Emails
            |--------------------------------------------------------------------------
            */

            $emailService = app(UserEmailService::class);

            $sent = 0;
            $failed = 0;
            $errors = [];

            foreach ($subscribers as $subscriber) {

                try {

                    $emailService->sendUserEmail(
                        $subscriber,
                        'promotion',
                        [
                            'promotion_text' => $newPromotionText
                        ]
                    );

                    $sent++;

                } catch (\Throwable $e) {

                    $failed++;

                    $errors[] = [
                        'email' => $subscriber->email,
                        'error' => $e->getMessage(),
                        'file'  => $e->getFile(),
                        'line'  => $e->getLine(),
                    ];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Return Email Result
            |--------------------------------------------------------------------------
            */

            if ($failed > 0) {

                return response()->json([
                    'status'  => false,
                    'message' => 'Settings updated, but some promotion emails failed.',
                    'debug' => [
                        'old_promotion' => $oldPromotionText,
                        'new_promotion' => $newPromotionText,
                        'promotion_changed' => true,
                        'subscriber_count' => $subscribers->count(),
                        'emails_sent' => $sent,
                        'emails_failed' => $failed,
                        'errors' => $errors,
                    ]
                ], 500);
            }
           
app(App\Services\OneSignalService::class)->sendToAdmins(
    'New Updates',
    "Hey Someone Updated Slimza Amin Setting"
);
            return response()->json([
                'status'  => true,
                'message' => 'Settings updated and promotion emails sent successfully.',
                'debug' => [
                    'old_promotion' => $oldPromotionText,
                    'new_promotion' => $newPromotionText,
                    'promotion_changed' => true,
                    'subscriber_count' => $subscribers->count(),
                    'emails_sent' => $sent,
                    'emails_failed' => 0,
                ]
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Promotion Did NOT Change
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status'  => true,
            'message' => 'Website settings updated successfully.',
            'debug' => [
                'old_promotion' => $oldPromotionText,
                'new_promotion' => $newPromotionText,
                'promotion_changed' => false,
                'subscriber_count' => 0,
                'emails_sent' => 0,
            ]
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status'  => false,
            'message' => 'Website settings update failed.',
            'error'   => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
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