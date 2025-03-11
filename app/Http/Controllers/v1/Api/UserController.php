<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\enums\AccountType;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\helpers\ApiResponse;
use App\services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registerUser(Request $request)
    {
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'account_type' => 'required|string|in:admin,owner,seller',
            'password' => 'required|string|min:8',
            'account_type' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('error', 422, $validator->errors());
        }

        $validatedData = $validator->validated();


        // Vérifier les permissions en fonction du type de compte
        $accountType = AccountType::from($validatedData['account_type']);
        $permission = 'manage ' . $accountType->value;

        /**if (!Auth::user()->hasAnyPermission($permission)) {
            return ApiResponse::error('You don\'t have permission to create this type of user.', 403);
        }**/
        // Créer l'utilisateur
        $response = $this->userService->registerUser($validatedData,AccountType::from($validatedData['account_type']));
        return ApiResponse::success($response,'User created successfully', 201);
    }


    public function login(Request $request)
    {
          // Valider les données de la requête
          $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', 422, $validator->errors());
        }

        $credentials = $request->only('email_or_phone', 'password');

        // Authentifier l'utilisateur
        $response = $this->userService->loginUser($credentials);

        if($response['status']){
           return ApiResponse::success($response,'Login successful',200 );
        }

        return ApiResponse::error($response['message'], 401);
    }
}
