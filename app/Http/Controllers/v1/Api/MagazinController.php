<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MagazinService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class MagazinController extends Controller
{
    protected $magazinService;

    public function __construct(MagazinService $magazinService)
    {
        $this->magazinService = $magazinService;
    }

    public function getMagazines($shopId)
    {
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view magazines.');
        }
        $magazines = $this->magazinService->getMagazines($shopId);
        return ApiResponse::success($magazines,'Magazines retrieved successfully',200);
    }

    public function getMagazine($id)
    {
        if(!Auth::user()->can('view magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to view magazines.');
        }
        $magazine = $this->magazinService->getMagazine($id);
        return ApiResponse::success($magazine,'Magazine retrieved successfully',200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to create magazines.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'shop_id' => 'integer|exists:shops,id'
        ]);
        // Retourner les erreurs de validation si elles existent
        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();





        $response = $this->magazinService->store($validatedData);

        return ApiResponse::success($response,'Magazine created successfully',201);
    }

    public function update(Request $request,$id)
    {
        if(!Auth::user()->can('update magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to update magazines.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string',
        ]);
        // dd($validator);

        // Retourner les erreurs de validation si elles existent
        if($validator->fails()){
            return ApiResponse::error('Validation error' , 422 , $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->magazinService->update($validatedData, $id);

        return ApiResponse::success($response,'Magazine updated successfully',200);
    }

    public function delete($id)
    {
        if(!Auth::user()->can('delete magazines')){
            return ApiResponse::error('Unauthorized' , 403 , 'You do not have permission to delete magazines.');
        }
        $response = $this->magazinService->delete($id);

        return ApiResponse::success($response,'Magazine deleted successfully',200);
    }

    
}
