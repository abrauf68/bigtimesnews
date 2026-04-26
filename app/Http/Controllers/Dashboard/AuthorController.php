<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view author');
        try {
            $authors = Author::all();
            return view('dashboard.authors.index', compact('authors'));
        } catch (\Throwable $th) {
            Log::error('Author Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create author');
        try {
            return view('dashboard.authors.create');
        } catch (\Throwable $th) {
            Log::error('Author Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create author');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'linkedin' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'threads' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Author Validation Failed', [
                'errors' => $validator->errors()->toArray(),
            ]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $author = new Author();
            $author->name = $request->name;
            $author->email = $request->email;
            $author->bio = $request->bio;
            $author->linkedin = $request->linkedin;
            $author->facebook = $request->facebook;
            $author->twitter = $request->twitter;
            $author->instagram = $request->instagram;
            $author->threads = $request->threads;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_author_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/authors', $filename);

                $author->image = 'storage/authors/' . $filename;
            }

            $author->save();

            DB::commit();
            return redirect()->route('dashboard.authors.index')->with('success', 'Author Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Author Store Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update author');
        try {
            $author = Author::findOrFail($id);
            return view('dashboard.authors.edit', compact('author'));
        } catch (\Throwable $th) {
            Log::error('Author Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update author');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'linkedin' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'threads' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $author = Author::findOrFail($id);
            $author->name = $request->name;
            $author->email = $request->email;
            $author->bio = $request->bio;
            $author->linkedin = $request->linkedin;
            $author->facebook = $request->facebook;
            $author->twitter = $request->twitter;
            $author->instagram = $request->instagram;
            $author->threads = $request->threads;

            if ($request->hasFile('image')) {
                if (!empty($author->image)) {
                    $oldPath = str_replace('storage/', 'public/', $author->image);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                $file = $request->file('image');
                $filename = time() . '_author_image.' . $file->getClientOriginalExtension();

                $file->storeAs('public/authors', $filename);

                $author->image = 'storage/authors/' . $filename;
            }

            $author->save();

            return redirect()->route('dashboard.authors.index')->with('success', 'Author Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Author Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete author');
        try {
            $author = Author::findOrFail($id);
            if (!empty($author->image)) {
                    $oldPath = str_replace('storage/', 'public/', $author->image);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }
            $author->delete();
            return redirect()->back()->with('success', 'Author Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Author Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function updateStatus(string $id)
    {
        $this->authorize('update author');
        try {
            $author = Author::findOrFail($id);
            $message = $author->is_active == 'active' ? 'Author Deactivated Successfully' : 'Author Activated Successfully';
            if ($author->is_active == 'active') {
                $author->is_active = 'inactive';
                $author->save();
            } else {
                $author->is_active = 'active';
                $author->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('author Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
