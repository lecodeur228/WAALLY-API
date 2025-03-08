<?php

use App\Http\Controllers\v1\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'ApiKeyVerify', 'prefix' => 'v1'], function(){
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::post('register', 'registerUser');
        Route::post('login','login');
    });
});
