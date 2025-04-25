<?php
namespace App\Core\Interfaces;

use App\Application\Auth\DTOs\OtpVerifyDTO;
use App\Core\Entities\User;

interface AuthRepositoryInterface{
    public function register(OtpVerifyDTO $dto): User;
}