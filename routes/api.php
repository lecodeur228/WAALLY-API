<?php

use App\Http\Controllers\v1\Api\ShopController;
use App\Http\Controllers\v1\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'ApiKeyVerify', 'prefix' => 'v1'], function(){

    Route::post('users/login', [UserController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::group(['prefix' => 'users'], function(){
            Route::post('register', [UserController::class, 'registerUser']);

        });
        // routes pour les admins
        Route::group(['prefix' => 'shops'], function(){
            Route::get('/', [ShopController::class, 'getShops']);
            Route::post('/store', [ShopController::class, 'store']);
            Route::put('/update/{id}', [ShopController::class, 'update']);
            Route::post('/delete/{id}', [ShopController::class, 'delete']);
            Route::post('/{shopId}/assign-user', [ShopController::class, 'assignUserToShop']);
        });
    });
});
