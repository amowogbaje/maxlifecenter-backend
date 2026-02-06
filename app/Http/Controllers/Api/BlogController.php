<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // -------------------
    // List posts (optional filters)
    // -------------------
    public function index(Request $request)
    {
        try {
            $query = Blog::published()->with(['categories', 'admin']);

            // Filter by category slug
            if ($request->has('category')) {
                $category = Category::where('slug', $request->category)->first();
                if ($category) {
                    $query->whereHas('categories', fn($q) => $q->where('id', $category->id));
                }
            }

            // Filter by featured
            if ($request->boolean('featured')) {
                $query->where('featured', true);
            }

            $limit = $request->get('limit', 10);
            $posts = $query->latest()->take($limit)->get();

            return response()->json(BlogResource::collection($posts));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch posts', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // Search posts
    // -------------------
    public function search(Request $request)
    {
        try {
            $query = Blog::published()->with(['categories', 'admin'])
                         ->where('title', 'like', '%'.$request->q.'%')
                         ->orWhere('body', 'like', '%'.$request->q.'%');

            $limit = $request->get('limit', 10);
            $posts = $query->latest()->take($limit)->get();

             return response()->json(BlogResource::collection($posts));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Search failed', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // Single post by slug
    // -------------------
    public function show($slug)
    {
        try {
            $post = Blog::published()->with(['categories', 'admin'])->where('slug', $slug)->first();
            if (!$post) return response()->json(null, 404);

            return response()->json(new BlogResource($post));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch post', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // Featured posts
    // -------------------
    public function featured(Request $request)
    {
        try {
            $limit = $request->get('limit', 5);
            $posts = Blog::published()->with(['categories', 'admin'])
                         ->where('featured', true)
                         ->latest()
                         ->take($limit)
                         ->get();

            return response()->json(BlogResource::collection($posts));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch featured posts', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // Related posts by post ID
    // -------------------
    public function related($id, Request $request)
    {
        try {
            $limit = $request->get('limit', 3);
            $post = Blog::published()->with('categories')->find($id);
            if (!$post) return response()->json([], 404);

            $categoryIds = $post->categories->pluck('id');
            if ($categoryIds->isEmpty()) return response()->json([]);

            $related = Blog::with(['categories', 'admin'])
                           ->whereHas('categories', fn($q) => $q->whereIn('id', $categoryIds))
                           ->where('id', '!=', $id)
                           ->latest()
                           ->take($limit)
                           ->get();

            return response()->json(BlogResource::collection($related));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch related posts', 'error' => $e->getMessage()], 500);
        }
    }

    public function postsByCategory($slug, Request $request)
    {
        try {
            $category = Category::where('slug', $slug)->first();
            if (!$category) return response()->json(['message' => 'Category not found'], 404);

            $limit = $request->get('limit', 10);
            $posts = Blog::published()->with(['categories', 'admin'])
                         ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
                         ->latest()
                         ->take($limit)
                         ->get();

            return response()->json(BlogResource::collection($posts));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch posts for category', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // All post slugs
    // -------------------
    public function allSlugs()
    {
        try {
            $slugs = Blog::published()->pluck('slug');
            return response()->json($slugs);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch slugs', 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------
    // All category slugs
    // -------------------
    public function allCategorySlugs()
    {
        try {
            $slugs = Category::pluck('slug');
            return response()->json($slugs);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch category slugs', 'error' => $e->getMessage()], 500);
        }
    }
}
