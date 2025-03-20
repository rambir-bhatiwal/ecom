<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('admin.index');
// });


// Route::get('/signin', function () {
//     return view('auth.signin');
// });


Route::get('/signup', [AuthController::class,'signUp'])->name('singup');
Route::post('/register', [AuthController::class,'register'])->name('register');
Route::get('/signin', [AuthController::class,'signIn'])->name('signin');
Route::post('/login', [AuthController::class,'loginUser'])->name('login');

// Route::get('/admin', [App\Http\Controllers\UserController::class, 'create']);


// include('/../routes/admin.php');
Route::get('/logout', function () {
    Auth::logout();
    // auth()->logout();
    return redirect()->route('signin');
});
require_once __DIR__.'/admin.php';