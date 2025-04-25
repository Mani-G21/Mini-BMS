<?php

namespace App\Infrastructure\Auth\Repositories;

use App\Application\Auth\DTOs\OtpVerifyDTO;
use App\Core\Entities\User;
use App\Core\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface {
    public function register(OtpVerifyDTO $dto): User {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email
        ]);
        return $user;
    }
}
