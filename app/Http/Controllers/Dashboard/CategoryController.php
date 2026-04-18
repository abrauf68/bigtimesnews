<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view category');
        try {
            $categories = Category::all();
            return view('dashboard.categories.index', compact('categories'));
        } catch (\Throwable $th) {
            Log::error('Category Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create category');
        try {
            return view('dashboard.categories.create');
        } catch (\Throwable $th) {
            Log::error('Category Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create category');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('Category Validation Failed', [
                'errors' => $validator->errors()->toArray(),
            ]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;

            if ($request->hasFile('image')) {
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/categories';
                $Image->move(public_path($Image_path), $Image_name);
                $category->image = $Image_path . "/" . $Image_name;
            }

            $category->save();

            DB::commit();
            return redirect()->route('dashboard.categories.index')->with('success', 'Category Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Category Store Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update category');
        try {
            $category = Category::findOrFail($id);
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Throwable $th) {
            Log::error('Category Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update category');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max_size',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;

            if ($request->hasFile('image')) {
                if (isset($category->image) && File::exists(public_path($category->image))) {
                    File::delete(public_path($category->image));
                }
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/categories';
                $Image->move(public_path($Image_path), $Image_name);
                $category->image = $Image_path . "/" . $Image_name;
            }

            $category->save();

            return redirect()->route('dashboard.categories.index')->with('success', 'Categories Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Categories Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete category');
        try {
            $category = Category::findOrFail($id);
            if (isset($category->image) && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
            $category->delete();
            return redirect()->back()->with('success', 'Category Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Category Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function updateStatus(string $id)
    {
        $this->authorize('update category');
        try {
            $category = Category::findOrFail($id);
            $message = $category->is_active == 'active' ? 'Category Deactivated Successfully' : 'Category Activated Successfully';
            if ($category->is_active == 'active') {
                $category->is_active = 'inactive';
                $category->save();
            } else {
                $category->is_active = 'active';
                $category->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Category Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
