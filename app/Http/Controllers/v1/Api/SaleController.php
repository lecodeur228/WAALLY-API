<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SaleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function getSales($shopId)
    {
        // if(!Auth::user()->can('view sale')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view sale.');
        // }
        $sales = $this->saleService->getSales($shopId);
        return ApiResponse::success($sales,'Sales retrieved successfully',200);
    }

    public function store(Request $request)
    {
        // if(!Auth::user()->can('create sale')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create sale.');
        // }
        $validator = Validator::make($request->all(), [
            'article_shop_id' => 'required|integer|exists:article_shops,id',
            'quantity' => 'required|integer',
            'customer_id' => 'required|integer|exists:customers,id',
            'sale_price' => 'required|numeric',
            'generateInvoice' => 'required|boolean',

        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->saleService->store($validatedData);
        if($response['status']){
            return ApiResponse::success($response,'Sales added successfully',201);
        }
        return ApiResponse::error($response['message'], 400);
    }

    public function delete($saleId)
    {
        // if(!Auth::user()->can('delete sale')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to delete sale.');
        // }
        $response = $this->saleService->delete($saleId);

      if($response['status']){
            return ApiResponse::success($response,'Sale deleted successfully',200);
        }
        return ApiResponse::error($response['message'], 400);

    }
}
