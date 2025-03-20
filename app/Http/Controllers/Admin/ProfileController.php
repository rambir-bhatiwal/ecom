<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile');
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
        //
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
    public function update(Request $request, string $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'insta_profile' => 'nullable|string|max:255',
            'fb_profile' => 'nullable|string|max:255',
            'twitter_profile' => 'nullable|string|max:255',
            'linkdin_profile' => 'nullable|string|max:255',
            'git_profile' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->insta_profile = $request->insta_profile;
        $user->fb_profile = $request->fb_profile;
        $user->twitter_profile = $request->twitter_profile;
        $user->linkdin_profile = $request->linkdin_profile;
        $user->git_profile = $request->git_profile;
        $user->website = $request->website;
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/profile');
            $image->move($destinationPath, $name);
            $user->profile = $name;
        }
        $user->save();
        // return redirect()->back()->with('success', 'Profile updated successfully');
        return response()->json(['message' => 'Profile updated successfully', 'status' => 200]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
