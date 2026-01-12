<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AuditLogService;


class BlogController extends Controller
{
    protected $auditLog;

    public function __construct(AuditLogService $auditLog)
    {
        $this->auditLog = $auditLog;
    }

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

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Paginate and transform images
        $updates = $query->paginate(9)->withQueryString();
        $updates->getCollection()->transform(function ($update) {
            $update->image = $update->image 
                ? asset($update->image) 
                :null;
                // : asset('images/default-thumbnail.jpg');
            return $update;
        });

        return view('admin.blogs.index', [
            'page_title' => 'Blog Posts',
            'updates' => $updates,
        ]);
    }


    public function create()
    {
        $data = [
            'page_title' => 'Create an Update',
        ];

        return view('admin.blogs.create', $data);
    }

    public function createTipTap()
    {
        $data = [
            'page_title' => 'Create an Update',
        ];

        return view('admin.blogs.create-tip-tap', $data);
    }

    public function createTrix()
    {
        $data = [
            'page_title' => 'Create an Update',
        ];

        return view('admin.blogs.create-trix', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => ['required', 'string', 'max:191'],
            'body'   => ['required', 'json'],
            'image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2040'],
            'status' => ['required', 'in:draft,published'],
        ]);

        try {
            $imagePath = $request->hasFile('image')
                ? $this->uploadAFile($request->file('image'), 'thumbnail')
                : null;

            $blog = Blog::create([
                'admin_id' => auth('admin')->id(),
                'title'    => $validated['title'],
                'slug'     => Str::slug($validated['title']),
                'body'     => json_decode($validated['body'], true),
                'image'    => $imagePath,
                'status'   => $validated['status'],
            ]);

            $this->auditLog->log(
                'create_blog',
                $blog,
                ['new' => $blog->toArray()],
                'Created new blog post: ' . $blog->title
            );

            return back()->with('success', 'Blog post created successfully.');
        } catch (\Throwable $e) {
            \Log::error('Blog creation failed', [
                'admin_id' => auth()->id(),
                'request'  => $request->except(['image']),
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to create blog post, please try again later.');
        }
    }



    public function edit(Blog $update)
    {
        $data = [
            'page_title' => 'Edit Blog Post',
            'update' => $update,
        ];

        

        return view('admin.blogs.edit', compact('update'));
    }

    public function update(Request $request, Blog $update)
    {
        $validated = $request->validate([
            'title'  => ['required', 'string', 'max:191'],
            'body'   => ['required', 'json'],
            'image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2040'],
            'status' => ['required', 'in:draft,published'],
        ]);

        try {
            $data = [
                'title'  => $validated['title'],
                'slug'   => Str::slug($validated['title']),
                'body'   => json_decode($validated['body'], true),
                'status' => $validated['status'],
            ];

            if ($request->hasFile('image')) {
                if ($update->image && file_exists(public_path($update->image))) {
                    @unlink(public_path($update->image));
                }

                $data['image'] = $this->uploadAFile($request->file('image'), 'thumbnail');
            }


            $oldData = $update->toArray();


            $updated = $update->update($data);

            $this->auditLog->log(
                'update_blog',
                $update,
                [
                    'old' => $oldData,
                    'new' => $update->fresh()->toArray(),
                ],
                'Updated blog post: ' . $update->title
            );

            if (! $updated) {
                \Log::warning('Blog update failed to persist', [
                    'blog_id' => $update->id,
                    'admin_id' => auth()->id(),
                ]);

                return back()->with('error', 'Failed to update blog post, please try again later.');
            }

            return back()->with('success', 'Blog post updated successfully.');
        } catch (\Throwable $e) {
            \Log::error('Blog update failed', [
                'blog_id' => $update->id ?? null,
                'admin_id' => auth()->id(),
                'request'  => $request->except(['image']),
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while updating the post.');
        }
    }


    public function uploadAFile($file, $path = 'uploads')
    {
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        return $path . '/' . $filename;
    }

    

    public function delete(Request $request)
    {
        $post = Blog::find($request->id);

        if (! $post) {
            flash()->addError('Failed to delete blog post, please try again later.');
        }

        $deleted = $post->delete();

        

        if ($deleted) {
            $oldData = $post->toArray();
            $this->auditLog->log(
                'delete_blog',
                $post,
                ['old' => $oldData],
                'Deleted blog post: ' . $post->title
            );
            flash()->addSuccess('Blog post has been deleting successfully.');
        } else {
            flash()->addError('An Error occured, please try again later.');
        }
    }

    
}
