<?php

use App\Http\Controllers\v1\Api\ArticleController;
use App\Http\Controllers\v1\Api\ShopController;
use App\Http\Controllers\v1\Api\StoreController;
use App\Http\Controllers\v1\Api\UserController;
use App\Http\Controllers\v1\Api\SupplierController;
use App\Http\Controllers\v1\Api\CustomerController;
use App\Http\Controllers\v1\Api\MagazinController;
use App\Http\Controllers\v1\Api\ApprovController;
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

        Route::get('users/me', [UserController::class, 'getUser']);

        Route::prefix('shops')->controller(ShopController::class)->group(function () {
            Route::get('/','getShops'); /** good */
            Route::get('/{shopId}','getShop'); /** good */
            // Route::get('/shopsByUser','getShopsByUser'); /** good */
            Route::post('/create','store'); /** good */
            Route::put('/update/{shopId}','update'); /** good */
            Route::delete('delete/{shopId}','delete'); /** good */

        });

        Route::prefix('customers')->controller(CustomerController::class)->group(function(){
            Route::get('/','getCustomers'); /** good */
            Route::get('/{id}','getCustomer'); /** good */
            Route::post('/','store'); /** good */
            Route::put('/update/{id}','update'); /** good */
            Route::delete('/delete/{id}','delete'); /** good */
        });


        Route::prefix('articles')->controller(ArticleController::class)->group(function(){
            Route::get('/','getArticles'); /** good */
            Route::post('/','store'); /** good */
            Route::put('/update/{articleId}','update'); /** good */
            Route::delete('/delete/{articleId}','delete'); /** good */
            Route::post('/addImages/{articleId}','addImages'); /** good */
        });

        Route::prefix('magazines')->controller(MagazinController::class)->group(function(){
            Route::get('/shops/{shopId}','getMagazines'); /** good */
            Route::get('/{magazineId}','getMagazine'); /** good */
            Route::post('/','store'); /** good */
            Route::put('/update/{magazineId}','update'); /** good */
            Route::delete('/delete/{magazineId}','delete'); /** good */
        });

        Route::prefix('stores')->controller(StoreController::class)->group(function(){
            Route::get('/','getStores'); /** good */
            Route::get('/relatedShops/{storeId}','getRelatedShops'); /** good */
            Route::get('/unrelatedShops/{storeId}','getUnrelatedShops'); /** good */
            Route::post('/addShops/{storeId}','addShops'); /** good */
            Route::post('/removeShops/{storeId}','removeShops'); /** good */
            Route::post('/create','store'); /** good */
            Route::post('/update/{storeId}','update'); /** good */
            Route::post('delete/{storeId}','delete'); /** good */
        });

        Route::prefix('suppliers')->controller(SupplierController::class)->group(function(){
            Route::get('/','getAll'); /** good */
            Route::get('/{id}','getById'); /** good */
            Route::get('/{name}','getByName'); /** good */
            Route::post('/','store'); /** good */
            Route::put('/update/{id}','update'); /** good */
            Route::get('/delete/{id}','delete'); /** good */
            Route::delete('/destroy/{id}','destroy'); /** good */
        });

        Route::prefix('approvs')->controller(ApprovController::class)->group(function(){
            Route::get('/shops/{shopId}','getApprovs'); /** good */
            Route::post('/','store'); /** good */
            Route::delete('/delete/{id}','delete'); /** good */
        });
    });
});
