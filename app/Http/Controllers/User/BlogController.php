<?php

namespace App\Http\Controllers\User;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query()->latest();

        // Filter by search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $query->where('status', 'published');

        // Paginate and transform images
        $updates = $query->paginate(2)->withQueryString();
        $updates->getCollection()->transform(function ($update) {
            $update->image = $update->image 
                ? asset($update->image) 
                :null;
                // : asset('images/default-thumbnail.jpg');
            return $update;
        });

        return view('user.blogs.index', [
            'page_title' => 'Blog Posts',
            'updates' => $updates,
        ]);
    }


    



    public function show(Blog $update)
    {
        $data = [
            'page_title' => 'View Blog Post',
            'update' => $update,
        ];

        

        return view('user.blogs.show', compact('update'));
    }

    


    

    
}
