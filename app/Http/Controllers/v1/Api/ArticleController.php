<?php

namespace App\Http\Controllers\V1\Api;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Shop;
use App\services\ArticleService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(Articleservice $articleService)
    {
        $this->articleService = $articleService;
    }

    /**public function getArticles($shopId){
        
        // Vérifier si l'utilisateur a la permission de 'view article'

        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view articles.');
        }

        $response = $this->articleService->getArticles($shopId);

        return ApiResponse::success($response , 'Articles retrieved successfully' , 200);
    } */

    public function getRelatedShops($id){

        // Vérifier si l'utilisateur a la permission de 'view article'

        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view shop.');
        }

        $response = $this->articleService->getRelatedShops($id);

        return ApiResponse::success($response , 'Shop retrieved successfully' , 200);
    }

    public function store(Request $request){
         
        // Vérifier si l'utilisateur a la permision 'create Artciles'
        if(!Auth::user()->can('create articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create articles.');
        }

        // valider les données

        $validator = Validator::make($request->all(),
        [
            "name"=> 'required|string|max:255',
            "description" => 'required|string|max:255',
            "sale_price" => 'required|numeric|max_digits:10|min_digits:2',
            "buy_price" => 'required|numeric|max_digits:10|min_digits:2',
            "shop_id" => 'required|array|min:1',
            "shop_id.*" => 'required|integer|exists:shops,id'
        ]);

        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        // Ajouter l'id du shop
        //$validatedData["shop_id"] = $shopId;

        $validatedDataWithoutShop['name'] = $validatedData['name'];
        $validatedDataWithoutShop['description'] = $validatedData['description'];
        $validatedDataWithoutShop['sale_price'] = $validatedData['sale_price'];
        $validatedDataWithoutShop['buy_price'] = $validatedData['buy_price'];

        $shopIds = $validatedData['shop_id'];

        $response = $this->articleService->store($validatedDataWithoutShop , $shopIds);

        return ApiResponse::success($response , 'Article created succesfully ' , 201);

    }

    public function addToshops(Request $request,$articelId){
        
        // Vérifier si l'utilisateur a la permision 'update Artciles'
        if(!Auth::user()->can('update articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update articles.');
        }

        // valider les données
        $validator = Validator::make($request->all(),
        [
            "shop_id"=> 'required|array|min:1',
            "shop_id.*" => 'required|integer|exists:shops,id'
        ]);

        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();
        $shopIds = $validatedData['shop_id'];
        $response = $this->articleService->addToshops($articelId , $shopIds);

        return ApiResponse::success($response , 'Article added succesfully to shops' , 200);
    }

    public function removeFromShop(Request $request,$articelId){

        // Vérifier si l'utilisateur a la permision 'update Artciles'
        if(!Auth::user()->can('update articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update articles.');
        }
        // valider les données
        $validator = Validator::make($request->all(),
        [
            "shop_id"=> 'required|array|min:1',
            "shop_id.*" => 'required|integer|exists:shops,id'
        ]);
        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();
        $shopIds = $validatedData['shop_id'];
        $response = $this->articleService->removeFromShops($articelId , $shopIds);

        return ApiResponse::success($response , 'Article removed succesfully from shops' , 200);
    }

    public function getUnrelatedShops($articelId){

        // Vérifier si l'utilisateur a la permision 'view articles'
        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view articles.');
        }

        $response = $this->articleService->getUnrelatedShops($articelId);

        return ApiResponse::success($response , 'Shops retrieved successfully' , 200);
    }

    public function update(Request $request, $id){
         // Vérifier si l'utilisateur a la permision 'update Artciles'
         if(!Auth::user()->can('update articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update articles.');
        }

        // valider les données

        $validator = Validator::make($request->all(),
        [
            "name"=> 'required|string|max:255',
            "description" => 'required|string|max:255',
            "sale_price" => 'required|numeric|max_digits:10|min_digits:2',
            "buy_price" => 'required|numeric|max_digits:10|min_digits:2',
        ]);

        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->articleService->update($validatedData , $id);

        return ApiResponse::success($response , 'Article updated succesfully ' , 200);

    }

    public function delete($articelId)
    {
        // Vérifier si l'utilisateur a la permission 'delete article'
        if (!Auth::user()->can('delete articles')) {
            return ApiResponse::error('Unauthorized', 403, 'You do not have permission to delete Article.');
        }

        $response = $this->articleService->delete($articelId);

        if($response != null){

            return ApiResponse::success($response,'Article deleted successfully',200);
        }
        return ApiResponse::error("The Shop do not exist" , 400);
        
    }
}
