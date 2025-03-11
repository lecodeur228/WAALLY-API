<?php

namespace App\Http\Controllers\V1\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Shop;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Api;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getArticles(Shop $shopId){
        
        // Vérifier si l'utilisateur a la permission de 'view article'

        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view articles.');
        }

        $response = $this->articleService->getArticles($shopId);

        return ApiResponse::success($response , 'Articles retrieved successfully' , 200);
    }

    public function getShop(){

        // Vérifier si l'utilisateur a la permission de 'view article'

        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view shop.');
        }

        $response = $this->articleService->getShop();

        return ApiResponse::success($response , 'Shop retrieved successfully' , 200);
    }

    public function store(Request $request , Shop $shopId){
         
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
            "bye_price" => 'required|numeric|max_digits:10|min_digits:2',
        ]);

        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        // Ajouter l'id du shop
        $validatedData["shop_id"] = $shopId;

        $response = $this->articleService->store($validatedData);

        return ApiResponse::success($response , 'Article created succesfully ' , 200);

    }

    public function update(Request $request ,Shop $shopId , Article $id){
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
            "bye_price" => 'required|numeric|max_digits:10|min_digits:2',
        ]);

        // Retourner les erreurs de validation si elles existent 

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        // ajouter l'id  du shop

        $validatedData['shop_id'] = $shopId;

        $response = $this->articleService->update($validatedData , $id);

        return ApiResponse::success($response , 'Article updated succesfully ' , 200);

    }

    public function delete(Article $id)
    {
        // Vérifier si l'utilisateur a la permission 'delete article'
        if (!Auth::user()->can('delete articles')) {
            return ApiResponse::error('Unauthorized', 403, 'You do not have permission to delete Article.');
        }

        $response = $this->articleService->delete($id);

        return ApiResponse::success($response,'Article deleted successfully',200);
    }
}
