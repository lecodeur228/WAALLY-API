<?php

namespace App\Http\Controllers\v1\Api;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\services\ShopService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Iam\V1\ApiKeyPage;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function getShops()
    {
        // Vérifier si l'utilisateur a la permission 'view shop'
        if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to view shop.']);
        }
        $response = $this->shopService->getShops();

        return ApiResponse::success($response,'Shops retrieved successfully',200);
    }

    public function getRelatedArticles($shopId)
    {
        // Vérifier si l'utilisateur a la parmission 'view articles'
        if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403,'You do not have permission to view article.');
        }
        
        $response = $this->shopService->getRelatedArticles($shopId);

        return ApiResponse::success($response , 'Artciles retrieved successfully' , 200);
    }

    public function getUnrelatedArticles($shopId){

        // Vérifier si l'utilisateur a la parmission 'view articles'
        if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403,'You do not have permission to view article.');
        }
        
        $response = $this->shopService->getUnrelatedArticles($shopId);

        return ApiResponse::success($response , 'Unrelated articles retrieved successfully' , 200);
    }

    public function getStores($shopId){
        // Vérifier su l'utilisateur a la parmission 'views articles'
        if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403,'You do not have permission to view magazins.');
        }
        
        $response = $this->shopService->getStores($shopId);

        return ApiResponse::success($response , 'Magazins retrieved successfully' , 200);
    }

    public function store(Request $request)
    {
        // dd($request);
        // Vérifier si l'utilisateur a la permission 'create shop'
        if (!Auth::user()->can('create shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to create shop.']);
        }
        // dd($request);
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();
        
        $validatedData['user_id'] = Auth::user()->id;
        $response = $this->shopService->store($validatedData);

        return ApiResponse::success($response,'Shop created successfully',200);
    }

    public function addArticles(Request $request,$shopId)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('update shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update shop.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|array|min:1',
            'article_id.*' => 'required|integer|exists:articles,id'
        ]);


        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();
        $articleIds = $validatedData['article_id'];
        $response = $this->shopService->addArticles($articleIds, $shopId);

        return ApiResponse::success($response,'Shop added successfully to articles',200);
    }

    public function removeArticles(Request $request,$shopId)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('update shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update shop.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|array|min:1',
            'article_id.*' => 'required|integer|exists:articles,id'
        ]);


        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();
        $articleIds = $validatedData['article_id'];
        $response = $this->shopService->removeArticles($shopId, $articleIds);

        return ApiResponse::success($response,'Shop removed successfully from articles',200);
    }

    public function update(Request $request,$shopId)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('update shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update shop.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        // dd($validator);  

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $validatedData['user_id'] = Auth::user()->id;
        $response = $this->shopService->update($validatedData, $shopId);
        if(!$response){
            return ApiResponse::error('Modification impossible' , 400);
        }

        return ApiResponse::success($response,'Shop updated successfully',200);
    }

    public function delete($shopId)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('delete shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to delete shop.']);
        }

        $response = $this->shopService->delete($shopId);

        return ApiResponse::success($response,'Shop deleted successfully',200);
    }

    /**public function assignUserToShop(Request $request, Shop $shopId)
    {

          // Vérifier si l'utilisateur a la permission 'manage boutique'
          if (!Auth::user()->can('update shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update shop.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
           
            'user_id' => 'required|integer|exists:users,id',
        ]);

         // Retourner les erreurs de validation si elles existent
         if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $userId = $request->input('user_id');
        $shop = $this->shopService->assignUserToShop($shopId, $userId);

        if ($shop) {
            return ApiResponse::success($shop,'User assigned to shop successfully', 200);
        }

        return ApiResponse::error('Shop not found', 404);
    }**/

}
