<?php

namespace App\services;

use App\Enums\AccountType;
use App\repositories\UserRepository;

class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($data,AccountType $accountType){
        $this->userRepository->register($data, $accountType);
    }

    public function loginUser(array $request)
    {
        return $this->userRepository->login($request);
    }

    public function getUser(){
        return $this->userRepository->getUser();
    }
}