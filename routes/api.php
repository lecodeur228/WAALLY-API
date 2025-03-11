<?php

use App\Http\Controllers\V1\Api\ArticleController;
use App\Http\Controllers\v1\Api\ShopController;
use App\Http\Controllers\v1\Api\UserController;
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

    Route::middleware('auth:sanctum')->group(function (){
        Route::prefix('shops')->controller(ShopController::class)->group(function () {
            Route::get('/','getShops');
            Route::get('/articles/{shopId}','getArticles');
            Route::get('/magazins/{shopId}','getMagazins');
            Route::post('/create','store');
            Route::put('/update/{shopId}','update');
            //Route::post('/assignedShop/{shopId}','assignUserToShop');
            Route::post('/delete/{shopId}','delete');
        });
    
        Route::prefix('articles')->controller(ArticleController::class)->group(function(){
            Route::get('/{shopId}','getArticles');
            Route::get('/shop','getShop');
            Route::post('/create/{shopId}','store');
            Route::post('/update/{shopId}','id');
            Route::delete('delete/{id}', 'delete');
        });
    });
});