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
            Route::get('/','getShops'); /** good */
            Route::get('/articles/{shopId}','getArticles'); /** good */
            Route::get('/magazins/{shopId}','getMagazins'); /** good */
            Route::post('/create','store'); /** good */
            Route::put('/update/{shopId}','update'); /** good */
            //Route::post('/assignedShop/{shopId}','assignUserToShop');
            Route::post('/delete/{shopId}','delete'); /** good */
        });
    
        Route::prefix('articles')->controller(ArticleController::class)->group(function(){
            Route::get('/{shopId}','getArticles'); /** good */
            Route::get('{ShopId}/shop','getShop'); /** good */
            Route::post('/create','store'); /** good */
            Route::post('/update/{shopId}/{articleId}','update'); /** good */
            Route::post('delete/{shopId}/{articleId}','delete'); /** good */
        });
    });
});