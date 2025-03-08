<?php

use App\Http\Controllers\v1\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'ApiKeyVerify', 'prefix' => 'v1'], function(){
    Route::group(['prefix' => 'users'], function(){
        Route::post('register', [UserController::class, 'registerUser']);
        Route::post('login', [UserController::class, 'login']);
    });
});
