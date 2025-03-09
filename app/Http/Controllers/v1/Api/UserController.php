<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Enums\AccountType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Helpers\ApiResponse;

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
        $permission = 'manage' . $accountType->value;

        if (!Auth::user()->hasAnyPermission($permission)) {
            return ApiResponse::error('You do not have permission to create this type of user.', 403);
        }

        // Créer l'utilisateur
        // tu as fais une boucle recursive
        $response = $this->userService->registerUser($validatedData,AccountType::from($validatedData['account_type']));

        return ApiResponse::success('User created successfully', 201, $response);
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
        // dd($response);

        return ApiResponse::success($response,'Login successful',200 );

    }
}
