<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brands;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $brands = Brands::all();
        return view('admin.brand.brand', get_defined_vars());
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
            'title' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/brands');
            $image->move($destinationPath, $image_name);
            Brands::updateOrCreate(['id' => $request->id],['image' => $image_name, 'title' => $request->title],);    
        }else{
            Brands::updateOrCreate(['id' => $request->id],['title' => $request->title],);
        }
        return response()->json(['success' => 'Brand added successfully.','status'=> 200]);
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
            'id' => 'required|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Brand not found.','status'=> 404]);
        }
        Brands::find($id)->delete();
        return response()->json(['success' => 'Brand deleted successfully.','status'=> 200]);
    }
}
