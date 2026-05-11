<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseStorageService
{

   public static function upload($file, $folder = '')
{
    $supabaseUrl = trim(env('SUPABASE_URL'), '/');
    $supabaseKey = env('SUPABASE_KEY');
    $bucket = env('SUPABASE_BUCKET');

    // 🔥 DEBUG SAFETY CHECK (IMPORTANT)
    if (!$supabaseUrl) {
        throw new \Exception("SUPABASE_URL is missing in .env");
    }

    $fileName = time() . '_' . $file->getClientOriginalName();
    $path = trim($folder . '/' . $fileName, '/');

    $url = $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $path;

    $response = Http::withHeaders([
        'apikey' => $supabaseKey,
        'Authorization' => 'Bearer ' . $supabaseKey,
        'Content-Type' => $file->getMimeType(),
    ])->withBody(
        file_get_contents($file),
        $file->getMimeType()
    )->post($url);

    if ($response->failed()) {
        throw new \Exception("Supabase upload failed: " . $response->body());
    }

    return $path;
}
    public static function getPublicUrl($path)
    {
        if (!$path) return null;

        return env('SUPABASE_URL')
            . '/storage/v1/object/public/'
            . env('SUPABASE_BUCKET')
            . '/'
            . $path;
    }
}