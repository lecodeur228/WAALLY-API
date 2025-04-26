<?php

namespace App\Repositories;

use App\Enums\AccountType;
use App\helpers\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserRepository {

    public function register(array $data, AccountType $accountType) {


        // Créer l'utilisateur
        $user = User::create([
            'name' => $data["name"],
            'email' =>  $data["email"],
            'phone' =>  $data["phone"],
            'password' => Hash::make( $data["password"]),
        ]);

        // Assigner le rôle à l'utilisateur
        $user->assignRole($accountType->value);

        return ApiResponse::success($user,'User created successfully', 201);
    }

    public function login(array $data){

        // Trouver l'utilisateur par email ou téléphone
        $user = User::where('email', $data['email_or_phone'])
                    ->orWhere('phone', $data['email_or_phone'])
                    ->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'Invalid credentials'
            ];
        }

        // Authentifier l'utilisateur
        Auth::login($user);
        // Créer un token pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;


        // Obtenir le rôle de l'utilisateur
        $role = $user->getRoleNames()->first();

         // Obtenir les permissions de l'utilisateur
         $permissions = $user->getAllPermissions()->pluck('name');

         // Sélectionner les informations spécifiques de l'utilisateur
         $userInfo = $user->only([
            'name',
            'email',
            'phone',
            'email_verified_at',
            'fcm_token',
            'created_at',
            'updated_at',
        ]);
        return  [
            'status' => true,
            'message' => 'Login succesfully',
            'user' => $userInfo,
            'role' => $role,
            'permissions' => $permissions,
            'token' => $token,
        ];
    }

    public function getUser() {
        $user = Auth::user();
        return $user;
    }
}
