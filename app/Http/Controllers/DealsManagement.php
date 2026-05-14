<?php

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SlimzaDeals;
use App\Services\SupabaseStorageService;

class DealsManagement extends Controller
{
  
    // GET ALL SlimzaDeals
public function index()
{
    $SlimzaDeals = SlimzaDeals::all();

    $SlimzaDeals = $SlimzaDeals->map(function ($deal) {
        $deal->image = $deal->image
            ? SupabaseStorageService::getPublicUrl($deal->image)
            : null;

        return $deal;
    });

    return response()->json([
        'message' => 'SlimzaDeals fetched successfully',
        'data' => $SlimzaDeals
    ]);
}
    // CREATE SlimzaDeals
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {

            $path = SupabaseStorageService::upload(
                $request->file('image'),
                'SlimzaDealss'
            );

            $validated['image'] = $path;
        }

        $SlimzaDeals = SlimzaDeals::create($validated);

        $SlimzaDeals->image = $SlimzaDeals->image
            ? SupabaseStorageService::getPublicUrl($SlimzaDeals->image)
            : null;

        return response()->json([
            'message' => 'SlimzaDeals created successfully',
            'data' => $SlimzaDeals
        ]);
    }

    // SHOW SINGLE SlimzaDeals
    public function show($id)
    {
        $SlimzaDeals = SlimzaDeals::findOrFail($id);

        $SlimzaDeals->image = $SlimzaDeals->image
            ? SupabaseStorageService::getPublicUrl($SlimzaDeals->image)
            : null;

        return response()->json([
            'message' => 'SlimzaDeals fetched successfully',
            'data' => $SlimzaDeals
        ]);
    }

    // UPDATE SlimzaDeals
    public function update(Request $request, $id)
    {
        $SlimzaDeals = SlimzaDeals::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {

            // DELETE OLD IMAGE
            if ($SlimzaDeals->image) {
                SupabaseStorageService::delete($SlimzaDeals->image);
            }

            // UPLOAD NEW IMAGE
            $path = SupabaseStorageService::upload(
                $request->file('image'),
                'SlimzaDealss'
            );

            $validated['image'] = $path;
        }

        $SlimzaDeals->update($validated);

        $SlimzaDeals->image = $SlimzaDeals->image
            ? SupabaseStorageService::getPublicUrl($SlimzaDeals->image)
            : null;

        return response()->json([
            'message' => 'SlimzaDeals updated successfully',
            'data' => $SlimzaDeals
        ]);
    }

    // DELETE SlimzaDeals
    public function destroy($id)
    {
        $SlimzaDeals = SlimzaDeals::findOrFail($id);

        // DELETE IMAGE FROM SUPABASE
        if ($SlimzaDeals->image) {
            SupabaseStorageService::delete($SlimzaDeals->image);
        }

        $SlimzaDeals->delete();

        return response()->json([
            'message' => 'SlimzaDeals deleted successfully'
        ]);
    }
}
