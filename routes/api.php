<?php

use App\Http\Controllers\v1\Api\ArticleController;
use App\Http\Controllers\v1\Api\ShopController;
use App\Http\Controllers\v1\Api\StoreController;
use App\Http\Controllers\v1\Api\UserController;
use App\Http\Controllers\v1\Api\SupplierController;
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
            Route::get('/relatedArticles/{shopId}','getRelatedArticles'); /** good */
            Route::get('/unrelatedArticles/{shopId}','getUnrelatedArticles'); /** good */
            Route::get('/relatedStores/{shopId}','getRelatedStores'); /** good */
            Route::get("/unrelatedStores/{shopId}",'getUnrelatedStores'); /** good */
            Route::post('/create','store'); /** good */
            Route::post('/addArticles/{shopId}','addArticles'); /** petit problème avec l'article d'id 1 */
            Route::post('/removeArticles/{shopId}','removeArticles'); /** good */
            Route::post("/addStores/{shopId}",'addStores');
            Route::post('/removeStores/{shopId}','removeStores');
            Route::put('/update/{shopId}','update'); /** good */
            Route::post('/delete/{shopId}','delete'); /** good */
        });

        Route::prefix('articles')->controller(ArticleController::class)->group(function(){
            Route::get('/{shopId}','getArticles'); /** good */
            Route::get('{shopId}/shop','getRelatedShops'); /** good */
            Route::post('/create','store'); /** good */
            Route::post('/addToshops/{articleId}','addToShops'); /** good */
            Route::post('/removeFromShops/{articleId}','removeFromShop'); /** good */
            Route::get('/unrelatedShops/{articleId}','getUnrelatedShops'); /** good */
            Route::post('/update/{articleId}','update'); /** good */
            Route::post('delete/{articleId}','delete'); /** good */
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
            // Route::get('/{id}','getById'); /** good */
            // Route::get('/{name}','getByName'); /** good */
            Route::post('/','store'); /** good */
            Route::put('/update/{id}','update'); /** good */
            Route::get('/delete/{id}','delete'); /** good */
            Route::delete('/destroy/{id}','destroy'); /** good */
        });
    });
});
