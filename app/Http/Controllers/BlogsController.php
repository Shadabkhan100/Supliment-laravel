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

public function blogsDetailsView($slug, $id)
{
    $blog = Blogs::findOrFail($id);

    // Optional safety check: slug mismatch handling
    if ($blog->slug !== $slug) {
        return redirect()->to("/blog-details/{$blog->slug}/{$blog->id}");
    }

    // Convert Supabase image to public URL
    $blog->image = $blog->image
        ? SupabaseStorageService::getPublicUrl($blog->image)
        : null;

    // -------------------------------
    // STATIC AUTHOR (demo object)
    // -------------------------------
    $author = (object) [
        'name' => 'Emily Brooks',
        'bio' => 'Emily Brooks is a content writer with strong expertise in health, fitness, and lifestyle topics. She creates engaging and research-based articles.',
        'image' => asset('/images/blogs/user.png'),
        'social' => [
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'linkedin' => '#',
        ]
    ];

   $comments = [
    [
        'id' => 101,
        'blog_id' => $blog->id,
        'user_id' => 11,
        'content' => 'Really helpful article. I learned a lot about nutrition timing and recovery.',
        'created_at' => '2025-08-24',

        'author' => [
            'name' => 'Jacob Thomas',
            'image' => asset('/images/blogs/user.png'),
            'description' => 'Fitness enthusiast and nutrition learner'
        ],

        'replies' => [
            [
                'id' => 201,
                'comment_id' => 101,
                'blog_id' => $blog->id,
                'user_id' => 1,
                'content' => 'Glad it helped you! Stay consistent and you’ll see results.',
                'created_at' => '2025-08-24',

                'author' => [
                    'name' => 'Emily Brooks',
                    'image' => asset('/images/blogs/user.png'),
                    'description' => 'Content writer & nutrition specialist'
                ],
            ],
            [
                'id' => 202,
                'comment_id' => 101,
                'blog_id' => $blog->id,
                'user_id' => 12,
                'content' => 'This made things much clearer, thanks!',
                'created_at' => '2025-08-25',

                'author' => [
                    'name' => 'Michael Scott',
                    'image' => asset('/images/blogs/user.png'),
                    'description' => 'Gym enthusiast'
                ],
            ]
        ],
    ],

    [
        'id' => 102,
        'blog_id' => $blog->id,
        'user_id' => 13,
        'content' => 'Great breakdown of vitamins. Very simple and clear.',
        'created_at' => '2025-08-24',

        'author' => [
            'name' => 'Ethan Michael',
            'image' => asset('/images/blogs/user.png'),
            'description' => 'Health blogger'
        ],

        'replies' => []
    ]
];

    return view('Modules.blogs-details', compact('blog', 'author', 'comments'));
}

}