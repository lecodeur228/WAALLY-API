<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService){
        $this->walletService = $walletService;
    }

    public function getWallets($shopId){
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view wallet.');
        }

        $wallets = $this->walletService->getWallets($shopId);
        return ApiResponse::success($wallets,'Wallets retrieved successfully',200);
    }

    public function getWallet($id){
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view wallet.');
        }

        $wallet = $this->walletService->getWallet($id);
        return ApiResponse::success($wallet,'Wallet retrieved successfully',200);
    }

    public function store(Request $request){
        // if(!Auth::user()->can('create wallets')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create wallet.');
        // }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $wallet = $this->walletService->store($validatedData);
        return ApiResponse::success($wallet,'Wallet created successfully',201);
    }


    public function update(Request $request,$id){
        // if(!Auth::user()->can('update wallets')){
        //     return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update wallet.');
        // }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        // dd($validator);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $wallet = $this->walletService->update($validatedData, $id);
        return ApiResponse::success($wallet,'Wallet updated successfully',200);
    }

    public function delete($id){
        if(!Auth::user()->can('delete wallets')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to delete wallet.');
        }
        $wallet = $this->walletService->delete($id);
        return ApiResponse::success($wallet,'Wallet deleted successfully',200);
    }
}
