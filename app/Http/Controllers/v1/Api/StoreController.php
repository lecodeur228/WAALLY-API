<?php

namespace App\Http\Controllers\v1\Api;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }
    public function getStores()
    {
        // vérifier si l'utilisateur a la permission 'view store'
        if (!Auth::user()->can('view store')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to view store.']);
        }
        $response = $this->storeService->getStores();

        return ApiResponse::success($response,'Stores retrieved successfully',200);
    }

    public function store(Request $request)
    {
        // vérifier si l'utilisateur a la permission 'create store'
        if (!Auth::user()->can('create store')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to create store.']);
        }
        // Vérifier les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'shop_id' => 'required|array|min:1',
            'shop_id.*' => 'required|integer|exists:shops,id'
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();
        
        $validatedDataWithoutShop['name'] = $validatedData['name'];
        $validatedDataWithoutShop['description'] = $validatedData['description'];

        $shopIds = $validatedData['shop_id'];

        $response = $this->storeService->store($validatedDataWithoutShop , $shopIds);

        return ApiResponse::success($response,'Store created successfully',200);
    }

    public function update(Request $request,$storeId)
    {
        // vérifier si l'utilisateur a la permission 'update store'
        if (!Auth::user()->can('update store')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update store.']);
        }
       
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // dd($validator);  

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->storeService->update($validatedData, $storeId);

        return ApiResponse::success($response,'Store updated successfully',200);
    }

    public function delete($storeId)
    {
        // vérifier si l'utilisateur a la permission 'delete store'
        if (!Auth::user()->can('delete store')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to delete store.']);
        }

        $response = $this->storeService->delete($storeId);

        return ApiResponse::success($response,'Store deleted successfully',200);
    }
}
