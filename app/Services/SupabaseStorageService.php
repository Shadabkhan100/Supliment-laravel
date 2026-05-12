<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseStorageService
{
    public static function upload($file, $folder = '')
    {
        $supabaseUrl = rtrim(config('supabase.url'), '/');
        $supabaseKey = config('supabase.key');
        $bucket = config('supabase.bucket');

        if (empty($supabaseUrl)) {
            throw new \Exception('SUPABASE_URL missing');
        }

        if (empty($supabaseKey)) {
            throw new \Exception('SUPABASE_KEY missing');
        }

        if (empty($bucket)) {
            throw new \Exception('SUPABASE_BUCKET missing');
        }

        $fileName = time() . '_' . $file->getClientOriginalName();

        $path = trim($folder . '/' . $fileName, '/');

        $url = $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $path;

        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => $file->getMimeType(),
        ])
        ->withBody(
            file_get_contents($file),
            $file->getMimeType()
        )
        ->post($url);

        if ($response->failed()) {

            throw new \Exception(
                'Supabase upload failed: ' . $response->body()
            );
        }

        return $path;
    }

    public static function getPublicUrl($path)
    {
        if (!$path) {
            return null;
        }

        return rtrim(config('supabase.url'), '/')
            . '/storage/v1/object/public/'
            . config('supabase.bucket')
            . '/'
            . $path;
    }
}