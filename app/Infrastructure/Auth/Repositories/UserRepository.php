<?php
namespace App\Infrastructure\Auth\Repositories;

use App\Core\Entities\User;
use App\Core\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface{
    public function findByEmail(string $email): ?User
    {
        $user = User::where('email', $email)->first();
        return $user;
    }
}
