<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{

    public function signUp(){
        return view('auth.signin');
    }
    public function signIn(){
        return view('auth.login');
    }
    public function register(Request $request){
        // dd($request->all());
        $validator = $request->validate([
            // 'email' => 'required|email|exists:users,email',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'Fname' => 'required|string|min:2',
            'Lname' => 'required|string|min:2'
        ]); 
    
        if ( is_object($validator) && $validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        
        
            return response()->json('User Created Successfully', 202);
            // return view('auth.login',compact('data'));        
        

        // return view('auth.register');
    }
    public function loginUser(Request $request) {
        // $validated = $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|string|min:6'
        // ]);

        // if($validated['fails']) {
        //     return response()->json($validated['errors'], 422);
        // }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> 400, 'message' => $validator->errors()->first()] );
        }
        if(Auth::attempt($request->only('email', 'password'), false)){
            // dd(Auth::user());
            if(Auth::User()->hasRole('admin')){
                return response()->json(['status'=> 200, 'message' =>'Admin Logged In Successfully', 'user' => Auth::user(),'url'=> '/admin/dashboard']);
            }
            return response()->json(['status'=> 200, 'message' =>'User Logged In Successfully']);

        }else{
            return response()->json(['status' => 404, 'message' => 'Invalid Credentials']);
        }
    }
}
