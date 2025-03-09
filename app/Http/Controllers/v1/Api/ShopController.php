<?php

namespace App\Http\Controllers\v1\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\ShopService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function getShops()
    {
         // Vérifier si l'utilisateur a la permission 'manage boutique'
         if (!Auth::user()->hasAnyPermission(['manage shop', 'manage admin'])) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to manage boutiques.']);
        }
        $response = $this->shopService->getShops();

        return ApiResponse::success($response,'Shops retrieved successfully',200);
    }

    public function store(Request $request)
    {
        // dd($request);
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->hasAnyPermission(['manage shop', 'manage admin'])) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to manage boutiques.']);
        }
        // dd($request);
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'user_id' => 'nullable|integer',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->shopService->store($validatedData);

        return ApiResponse::success($response,'Shop created successfully',201);
    }

    public function update(Request $request, $id)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->hasAnyPermission(['manage shop', 'manage admin'])) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to manage boutiques.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        // dd($validator);  

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->shopService->update($validatedData, $id);

        return ApiResponse::success($response,'Shop updated successfully',200);
    }

    public function delete($id)
    {
        // Vérifier si l'utilisateur a la permission 'manage shop'&& 'manage admin'
        if (!Auth::user()->hasAnyPermission(['manage shop', 'manage admin'])) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to manage boutiques.']);
        }

        $response = $this->shopService->delete($id);

        return ApiResponse::success($response,'Shop deleted successfully',200);
    }

    public function assignUserToShop(Request $request, $shopId)
    {

          // Vérifier si l'utilisateur a la permission 'manage boutique'
          if (!Auth::user()->hasAnyPermission(['manage shop', 'manage admin'])) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to manage boutiques.']);
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
    }

}
