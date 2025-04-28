<?php

namespace App\Http\Controllers\v1\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\ShopService;
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


    public function getShop($id)
    {
        // Vérifier si l'utilisateur a la permission 'view shop'
        if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to view shop.']);
        }

        $response = $this->shopService->getShop($id);
        if(!$response){
            return ApiResponse::error('Shop not found', 404);
        }
        return ApiResponse::success($response,'Shop retrieved successfully',200);
    }

    // public function getShopsByUser()
    // {
    //     // Vérifier si l'utilisateur a la permission 'view shop'
    //     if (!Auth::user()->can('view shop')) {
    //         return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to view shop.']);
    //     }
    //     $response = $this->shopService->getShopsByUser();
    //     return ApiResponse::success($response,'Shops retrieved successfully',200);
    // }


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
            'location' => 'required|json',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();
        $response = $this->shopService->store($validatedData);

        return ApiResponse::success($response,'Shop created successfully',200);
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
            'location' => 'required|json',
        ]);

        // dd($validator);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

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


}
