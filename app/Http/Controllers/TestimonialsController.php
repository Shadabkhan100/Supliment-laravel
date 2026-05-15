<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonials;
use Illuminate\Support\Str;
use App\Services\SupabaseStorageService;
class TestimonialsController extends Controller
{
    public function index()
{
    $testimonials = Testimonials::latest()->get();

    $testimonials->transform(function ($item) {

        $item->image = $item->image
            ? SupabaseStorageService::getPublicUrl($item->image)
            : null;

        return $item;
    });

    return response()->json($testimonials);
}

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'message' => 'required',
        'rating' => 'nullable|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $validated = $request->only([
        'name',
        'role',
        'message',
        'rating'
    ]);

    $validated['role'] = $request->role ?? 'Customer';
    $validated['rating'] = $request->rating ?? 5;

    // IMAGE UPLOAD TO SUPABASE (same pattern as blogs)
    if ($request->hasFile('image')) {

        $path = SupabaseStorageService::upload(
            $request->file('image'),
            'Testimonials' // 👈 separate folder for clarity
        );

        $validated['image'] = $path;
    }

    $testimonial = Testimonials::create($validated);

    return response()->json([
        'message' => 'Testimonial created successfully',
        'data' => $testimonial
    ]);
}
   public function destroy($id)
{
    $testimonial = Testimonials::findOrFail($id);

        $testimonial->delete();

    return response()->json([
        'message' => 'Testimonial deleted successfully'
    ]);
}
}