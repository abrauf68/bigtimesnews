<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view post');
        try {
            return view('dashboard.posts.index');
        } catch (\Throwable $th) {
            Log::error('Posts Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function getPostsData()
    {
        try {
            $posts = Post::with('category')->latest()->select('posts.*');

            return DataTables::of($posts)
                ->addIndexColumn()
                ->editColumn('title', function ($post) {
                    return \Illuminate\Support\Str::limit($post->title, 20, '...');
                })
                ->editColumn('category', function ($post) {
                    return $post->category ? $post->category->name : 'N/A';
                })
                ->editColumn('created_at', function ($post) {
                    return $post->created_at->format('d M Y');
                })
                ->editColumn('status', function ($post) {
                    $badgeClass = $post->status == 'published' ? 'success' : 'secondary';
                    return '<span class="badge me-4 bg-label-' . $badgeClass . '">' . ucfirst($post->status) . '</span>';
                })
                ->addColumn('action', function ($post) {
                    $actions = '';

                    if (auth()->user()->can('delete post')) {
                        $actions .= '<form action="' . route('dashboard.posts.destroy', $post->id) . '" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="#" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Post">
                                        <i class="ti ti-trash ti-md"></i>
                                    </a>
                                </form>';
                    }

                    if (auth()->user()->can('update post')) {
                        $actions .= '<span class="text-nowrap d-inline-block">
                                    <a href="' . route('dashboard.posts.edit', $post->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Post">
                                        <i class="ti ti-edit ti-md"></i>
                                    </a>
                                </span>';

                        $toggleIcon = $post->status == 'published' ? 'ti-toggle-right text-success' : 'ti-toggle-left text-secondary';
                        $actions .= '<span class="text-nowrap d-inline-block">
                                    <a href="' . route('dashboard.posts.status.update', $post->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="' . ($post->status == 'published' ? 'Draft Post' : 'Publish Post') . '">
                                        <i class="ti ' . $toggleIcon . ' ti-md"></i>
                                    </a>
                                </span>';
                    }

                    return $actions;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } catch (\Throwable $th) {
            Log::error('Posts DataTable Failed', ['error' => $th->getMessage()]);
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create post');
        try {
            $categories = Category::where('is_active', 'active')->get();
            $authors = Author::where('is_active', 'active')->get();
            $uniqueTags = collect(Post::pluck('tags'))
                ->map(function ($item) {
                    return json_decode($item, true); // Convert string to array
                })
                ->flatten()
                ->filter() // remove nulls
                ->unique()
                ->values()
                ->all();
            return view('dashboard.posts.create', compact('categories', 'uniqueTags', 'authors'));
        } catch (\Throwable $th) {
            Log::error('Post Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create post');
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'content' => 'required',
            'tags' => 'nullable',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::error('Post Validation Failed', [
                'errors' => $validator->errors()->toArray(),
            ]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $post = new Post();
            $post->user_id = auth()->id();
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->category_id = $request->category_id;
            $post->author_id = $request->author_id;
            $post->content = $request->content;
            $post->meta_title = $request->meta_title;
            $post->meta_description = $request->meta_description;
            $post->meta_keywords = $request->meta_keywords;
            if ($request->tags) {
                $tags = json_encode(
                    collect(json_decode($request->tags, true))->pluck('value')->all()
                );
                $post->tags = $tags;
            }

            if ($request->hasFile('meta_image')) {

                $file = $request->file('meta_image');
                $filename = time() . '_meta_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/posts', $filename);

                $post->meta_image = 'storage/posts/' . $filename;
            }

            if ($request->hasFile('main_image')) {

                $file = $request->file('main_image');
                $filename = time() . '_main_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/posts', $filename);

                $post->main_image = 'storage/posts/' . $filename;
            }

            $post->save();

            DB::commit();
            return redirect()->route('dashboard.posts.index')->with('success', 'Post Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Post Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update post');
        try {
            $categories = Category::where('is_active', 'active')->get();
            $authors = Author::where('is_active', 'active')->get();
            $uniqueTags = collect(Post::pluck('tags'))
                ->map(function ($item) {
                    if (is_array($item)) {
                        return $item; // already decoded
                    }

                    if (is_string($item)) {
                        return json_decode($item, true);
                    }

                    return [];
                })
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
            $post = Post::findOrFail($id);
            return view('dashboard.posts.edit', compact('categories', 'uniqueTags', 'post', 'authors'));
        } catch (\Throwable $th) {
            Log::error('Post Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update post');
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'content' => 'required',
            'tags' => 'nullable',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            DB::beginTransaction();
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->category_id = $request->category_id;
            $post->author_id = $request->author_id;
            $post->content = $request->content;
            $post->meta_title = $request->meta_title;
            $post->meta_description = $request->meta_description;
            $post->meta_keywords = $request->meta_keywords;
            if ($request->tags) {
                $tags = json_encode(
                    collect(json_decode($request->tags, true))->pluck('value')->all()
                );
                $post->tags = $tags;
            }

            if ($request->hasFile('meta_image')) {

                // delete old file
                if (!empty($post->meta_image)) {
                    $oldPath = str_replace('storage/', 'public/', $post->meta_image);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                // upload new file
                $file = $request->file('meta_image');
                $filename = time() . '_meta_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/posts', $filename);

                $post->meta_image = 'storage/posts/' . $filename;
            }

            if ($request->hasFile('main_image')) {

                // delete old file
                if (!empty($post->main_image)) {
                    $oldPath = str_replace('storage/', 'public/', $post->main_image);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                // upload new file
                $file = $request->file('main_image');
                $filename = time() . '_main_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/posts', $filename);

                $post->main_image = 'storage/posts/' . $filename;
            }

            $post->save();
            DB::commit();
            return redirect()->route('dashboard.posts.index')->with('success', 'Post Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Post Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete post');
        try {
            $post = Post::findOrFail($id);
            if (!empty($post->meta_image)) {
                $oldPath = str_replace('storage/', 'public/', $post->meta_image);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            if (!empty($post->main_image)) {
                $oldPath = str_replace('storage/', 'public/', $post->main_image);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            $post->delete();
            return redirect()->back()->with('success', 'Post Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Post Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function updateStatus(string $id)
    {
        $this->authorize('update post');
        try {
            $post = Post::findOrFail($id);
            $message = $post->status == 'published' ? 'Post Deactivated Successfully' : 'Post Activated Successfully';
            if ($post->status == 'published') {
                $post->status = 'draft';
                $post->save();
            } else {
                $post->status = 'published';
                $post->published_at = Carbon::now();
                $post->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Post Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048',
        ]);

        $file = $request->file('file');

        // Clean original name (without extension)
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Make slug + unique timestamp
        $filename = time() . '-' . Str::slug($name) . '.' . $file->getClientOriginalExtension();

        // Store
        $file->storeAs('public/posts/content', $filename);

        return response()->json([
            'location' => url('storage/posts/content/' . $filename) // ✅ full URL
        ]);
    }
}
