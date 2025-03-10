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
         if (!Auth::user()->can('view shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to view shop.']);
        }
        $response = $this->shopService->getShops();

        return ApiResponse::success($response,'Shops retrieved successfully',200);
    }

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('create shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to create shop.']);
        }

        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255|max_digits:',
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
        if (!Auth::user()->can('update shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to update shop.']);
        }

        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

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
        // Vérifier si l'utilisateur a la permission 'manage boutique'
        if (!Auth::user()->can('delete shop')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to delete shop.']);
        }

        $response = $this->shopService->delete($id);

        return ApiResponse::success($response,'Shop deleted successfully',200);
    }

}
