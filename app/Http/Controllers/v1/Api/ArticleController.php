<?php

namespace App\Http\Controllers\V1\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Shop;
use App\Services\ArticleService;
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

    public function getArticles(){

        // Vérifier si l'utilisateur a la permission de 'view article'

        if(!Auth::user()->can('view articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view articles.');
        }

        $response = $this->articleService->getArticles();

        return ApiResponse::success($response , 'Articles retrieved successfully' , 200);
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
            "description" => 'string|max:255',
            "sale_price" => 'required|numeric|max_digits:10|min_digits:2',
            "purchase_price" => 'required|numeric|max_digits:10|min_digits:2',
            "supplier_id" => 'required|integer|exists:suppliers,id',
            "images" => 'required|array|min:1',
            "images.*" => 'image|mimes:jpeg,png,jpg'
        ]);

        // Retourner les erreurs de validation si elles existent

        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->articleService->store($validatedData);

        return ApiResponse::success($response , 'Article created succesfully ' , 201);

    }

    public function addImages(Request $request, $id){
        // Vérifier si l'utilisateur a la permision 'update Artciles'
        if(!Auth::user()->can('update articles')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update articles.');
        }
        // valider les données
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg'
        ]);
        // Retourner les erreurs de validation si elles existent
        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }
        $validatedData = $validator->validated();
         $this->articleService->addImagesToArticle($validatedData , $id);
        return ApiResponse::success( 'Article updated succesfully ' , 200);
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
            "purchase_price" => 'required|numeric|max_digits:10|min_digits:2',
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
