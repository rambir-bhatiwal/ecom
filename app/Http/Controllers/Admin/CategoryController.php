<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use App\Models\CategoryAttribute;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Category::all();
        return view('admin.categories.category', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:1',
            'slug' => 'required|string|max:255|min:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        if(isset($request->parent_id) && $request->parent_id != null && $request->parent_id != '' && $request->parent_id != 0){  

            $Category = Category::updateOrCreate(['id' => $request->id],['name' => $request->name, 'slug' => $request->slug, 'parent_id' => $request->parent_id]);
        }else{
            $Category = Category::updateOrCreate(['id' => $request->id],['name' => $request->name, 'slug' => $request->slug]);
        }
        return response()->json(['success' => 'Category saved successfully', 'status' => 200]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:categories,id',
        ]);        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }

        $Category = Category::find($id);
        $Category->delete();
        return response()->json(['success' => 'Category deleted successfully', 'status' => 200]);
    }

    // attribute section start
    public function index_attribute()
    {
        $data = CategoryAttribute::with('category', 'attribute')->get();
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('admin.categories.attributes', get_defined_vars());
    }


        /**
     * Store a newly created resource in storage.
     */
    public function store_attribute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        CategoryAttribute::updateOrCreate(['id' => $request->id],['category_id' => $request->category_id, 'attribute_id' => $request->attribute_id]);
        return response()->json(['success' => 'Category saved successfully', 'status' => 200]);
    }

    public function destroy_attribute(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:category_attribute,id',
        ]);        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }

        $Category = CategoryAttribute::find($id);
        $Category->delete();
        return response()->json(['success' => 'Category attribute deleted successfully', 'status' => 200]);
    }

}
