<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FinanceService;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    protected $financeService;

    public function __construct(FinanceService $financeService){
        $this->financeService = $financeService;
    }

    public function getFinances($walletId){
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view finances.');
        }
        $finances = $this->financeService->getFinances($walletId);
        return ApiResponse::success($finances,'Finances retrieved successfully',200);
    }

    public function getFinance($id){
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view finances.');
        }
        $finance = $this->financeService->getFinance($id);
        return ApiResponse::success($finance,'Finance retrieved successfully',200);
    }

    public function store(Request $request){
        if(!Auth::user()->can('create finances')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create finances.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|max_digits:10|min_digits:2',
            'wallet_id' => 'required|integer|exists:wallets,id',
            'type' => 'required|string|in:deposit,withdrawal',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $wallet = $this->walletService->getWallet($validatedData['wallet_id']);

        if($wallet->balance < $validatedData['balance']){
            return ApiResponse::error('Insufficient balance', 400);
        }

        $finance = $this->financeService->store($validatedData);
        return ApiResponse::success($finance,'Finance created successfully',201);
    }

    public function delete($id){
        if(!Auth::user()->can('delete finances')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to delete finances.');
        }
        $finance = $this->financeService->delete($id);
        return ApiResponse::success($finance,'Finance deleted successfully',200);
    }
}
