<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Validator;
class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners['banners'] = HomeBanner::all();
        return view('admin.homebanner',$banners);
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
        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'nullable',
            'image' => 'nullable',
            'link' => 'nullable',
            'description' => 'nullable',
            'btn_text' => 'nullable',
            'btn_link' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()->first(), 'status' => 400]);
        }
        if($request->hasFile('image')){
            $request->file('image')->move('uploads/banners/', $request->file('image')->getClientOriginalName());
            $image = $request->file('image')->getClientOriginalName();
        }
        $homebanner = new HomeBanner();
        $homebanner->title = $request->title;
        $homebanner->subtitle = $request->subtitle;
        $homebanner->image = $image ?? '';
        $homebanner->link = $request->link;
        $homebanner->description = $request->description;
        $homebanner->btn_text = $request->btn_text;
        $homebanner->btn_link = $request->btn_link;
        $homebanner->status = $request->status;
        $homebanner->save();

        return response()->json(['success' => 'Banner added successfully', 'status' => 200]);
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
        //
    }
}
