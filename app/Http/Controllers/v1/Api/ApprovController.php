<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApprovService;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;

class ApprovController extends Controller
{
    //
    protected $approvalService;

    public function __construct(ApprovService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function getApprovs($shopId)
    {
        //  if(!Auth::user()->can('view approvs')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view magazines.');
        // }
        $approvals = $this->approvalService->getApprovals($shopId);
        return ApiResponse::success($approvals,'Approvs retrieved successfully',200);
    }

    public function store(Request $request)
    {
        // if(!Auth::user()->can('create approvs')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create approvs.');
        // }
       $validator = Validator::make($request->all(), [
            'article_id' => 'required|integer|exists:articles,id',
            'shop_id' => 'required|integer|exists:shops,id',
            'magazine_id' => 'required|integer|exists:magazines,id',
            'quantity' => 'required|integer',
            'type' => 'required|string|in:WarehouseSupplyAction,SaleSupplyAction',
        ]);


        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->approvalService->store($validatedData);
        if($response['status']){
            return ApiResponse::success($response,'Approval created successfully',201);
        }
        return ApiResponse::error($response['message'], 400);
    }

    public function delete($id)
    {
        // if(!Auth::user()->can('delete approvs')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to delete approvs.');
        // }
        $response = $this->approvalService->delete($id);
        if($response['status']){
            return ApiResponse::success($response,'Approval deleted successfully',200);
        }
        return ApiResponse::error($response['message'], 400);
    }
}
