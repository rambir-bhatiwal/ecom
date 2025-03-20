<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\AttributeController;

Route::prefix('admin')->middleware('admin')->group(function () {
    // Route::get('/profile', function () {
    //     return view('admin.profile');
    // });
    Route::get('/dashboard', [dashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    // Route::get('/signin', function () {
        //     return view('auth.signin');
        // });
        // Route::get('/signup', function () {
            //     return view('auth.signup');
            // });
            // Route::get('/login', function () {
                //     return view('auth.login');
                // });    
                
            
    // home banner
    Route::get('/banners', [HomeBannerController::class, 'index']);
    Route::post('/banners/store', [HomeBannerController::class, 'store']);

    // Size Route
    Route::get('/sizes', [SizeController::class, 'index']);
    Route::post('/sizes/store', [SizeController::class, 'store']);
    Route::get('/sizes/delete/{id}', [SizeController::class, 'destroy']);

    // Color Route
    Route::get('/colors', [ColorController::class, 'index']);
    Route::post('/colors/store', [ColorController::class, 'store']);
    Route::get('/colors/delete/{id}', [ColorController::class, 'destroy']);

    // Attribute Route
    Route::get('/attributes', [AttributeController::class, 'index']);
    Route::post('/attributes/store', [AttributeController::class, 'store']);
    Route::get('/attributes/delete/{id}', [AttributeController::class, 'destroy']);
    
    // Attribute Value Route
    Route::get('/attributes-value', [AttributeController::class, 'index_value']);
    Route::post('/attributes-value/store', [AttributeController::class, 'store_value']);
    Route::get('/attributes-value/delete/{id}', [AttributeController::class, 'destroy_value']);
});
         

