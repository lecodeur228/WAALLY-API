<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Services\SupplierService;


class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function getAll()
    {
        $response = $this->supplierService->getAllSuppliers();

        return ApiResponse::success($response,'Suppliers retrieved successfully',200);

    }
    public function getById($id)
    {
        $response = $this->supplierService->getSupplierById($id);

        return ApiResponse::success($response,'Supplier retrieved successfully',200);

    }

    public function getByName($name)
    {
        $response = $this->supplierService->getSupplierByName($name);

        return ApiResponse::success($response,'Supplier retrieved successfully',200);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->supplierService->create($validatedData);

        return ApiResponse::success($response,'Supplier created successfully',201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $response = $this->supplierService->update($id, $validatedData);

        return ApiResponse::success($response,'Supplier updated successfully',200);
    }

    public function delete($id)
    {
        $response = $this->supplierService->delete($id);

        return ApiResponse::success($response,'Supplier deleted successfully',200);
    }


    public function destroy($id)
    {
        $response = $this->supplierService->destroy($id);

        return ApiResponse::success($response,'Supplier destroyed successfully',200);
    }

}
