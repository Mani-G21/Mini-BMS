<?php
namespace App\Infrastructure\Auth\Services;

use App\Application\Auth\DTOs\OtpVerifyDTO;
use App\Core\Interfaces\AuthRepositoryInterface;
use App\Core\Interfaces\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService{
    protected AuthRepositoryInterface $authRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(AuthRepositoryInterface $authRepo, UserRepositoryInterface $userRepo)
    {
        $this->authRepo = $authRepo;
        $this->userRepo = $userRepo;
    }

    public function registerOrLogin(OtpVerifyDTO $dto): string{
        $user = $this->userRepo->findByEmail($dto->email);
        if(!$user){
            $user = $this->authRepo->register($dto);
        }

        return JWTAuth::fromUser($user);
    }
}