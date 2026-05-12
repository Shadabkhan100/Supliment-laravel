<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SupabaseStorageService;

class BlogsController extends Controller
{
    /**
     * Get all Blogs
     */
    public function index()
    {
        $blogs = Blogs::latest()->get();

        $blogs->transform(function ($blog) {

            $blog->image = $blog->image
                ? SupabaseStorageService::getPublicUrl($blog->image)
                : null;

            return $blog;
        });

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs,
        ]);
    }

    /**
     * Add new Blog
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'publish_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        // IMAGE UPLOAD TO SUPABASE
        if ($request->hasFile('image')) {

            $path = SupabaseStorageService::upload(
                $request->file('image'),
                'Blogs'
            );

            $validated['image'] = $path;
        }

        $blog = Blogs::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . time(),
            'author' => $validated['author'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?? null,
            'publish_date' => $validated['publish_date'] ?? now(),
            'status' => $validated['status'] ?? true,
        ]);

        // RETURN PUBLIC IMAGE URL
        $blog->image = $blog->image
            ? SupabaseStorageService::getPublicUrl($blog->image)
            : null;

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
            'data' => $blog,
        ]);
    }

    /**
     * View single Blog
     */
    public function show($id)
    {
        $blog = Blogs::find($id);

        if (!$blog) {

            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        $blog->image = $blog->image
            ? SupabaseStorageService::getPublicUrl($blog->image)
            : null;

        return response()->json([
            'status' => true,
            'data' => $blog,
        ]);
    }

    /**
     * Update Blog
     */
    public function update(Request $request, $id)
    {
        $blog = Blogs::find($id);

        if (!$blog) {

            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'publish_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        // IMAGE UPLOAD TO SUPABASE
        if ($request->hasFile('image')) {

            $path = SupabaseStorageService::upload(
                $request->file('image'),
                'Blogs'
            );

            $blog->image = $path;
        }

        if (isset($validated['title'])) {

            $blog->title = $validated['title'];

            $blog->slug = Str::slug($validated['title']) . '-' . time();
        }

        $blog->author = $validated['author'] ?? $blog->author;

        $blog->short_description = $validated['short_description']
            ?? $blog->short_description;

        $blog->description = $validated['description']
            ?? $blog->description;

        $blog->publish_date = $validated['publish_date']
            ?? $blog->publish_date;

        if (isset($validated['status'])) {

            $blog->status = $validated['status'];
        }

        $blog->save();

        // RETURN PUBLIC URL
        $blog->image = $blog->image
            ? SupabaseStorageService::getPublicUrl($blog->image)
            : null;

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ]);
    }

    /**
     * Delete Blog
     */
    public function destroy($id)
    {
        $blog = Blogs::find($id);

        if (!$blog) {

            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }
}