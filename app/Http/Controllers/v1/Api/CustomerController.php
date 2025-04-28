<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getCustomers()
    {
        $customers = $this->customerService->getCustomers();
        return response()->json($customers);
    }

    public function getCustomer($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        // verifier si utilisateur a la permission de 'create customer'
        if (!Auth::user()->can('create customer')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to create customer.']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $customer = $this->customerService->store($validatedData);
        return response()->json($customer);
    }

    public function update(Request $request,$id)
    {
          if (!Auth::user()->can('update customer')) {
            return ApiResponse::error('Unauthorized', 403, ['message' => 'You do not have permission to create customer.']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();

        $customer = $this->customerService->update($validatedData, $id);
        return ApiResponse::success($customer,'Customer updated successfully', 200);
    }

    public function delete($id)
    {
        $customer = $this->customerService->delete($id);
        return ApiResponse::success($customer,'Customer deleted successfully', 200);
    }
}
