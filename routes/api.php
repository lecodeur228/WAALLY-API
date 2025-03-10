<?php

use App\Http\Controllers\v1\Api\ShopController;
use App\Http\Controllers\v1\Api\UserController;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('ApiKeyVerify')->prefix('v1')->group(function(){
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::post('register', 'registerUser');
        Route::post('login','login');
    });
});

Route::prefix('v1')->controller(ShopController::class)->group(function () {
    Route::get('/shops','getShops');
    Route::post('/shops/create','store');
    Route::post('/shops/update/{id}','update');
    Route::delete('/shops/delete/{id}','delete');
});

Route::prefix('v1')->controller()->groupe(function(){
    
});