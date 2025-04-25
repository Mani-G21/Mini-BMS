<?php

namespace App\Http\Controllers\API;

use App\Application\Auth\DTOs\OtpSendDTO;
use App\Application\Auth\DTOs\OtpVerifyDTO;
use App\Application\Auth\Validators\OtpSendValidator;
use App\Application\Auth\Validators\OtpVerifyValidator;
use App\Http\Controllers\Controller;
use App\Infrastructure\Auth\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Infrastructure\Auth\Services\OtpService;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected OtpService $otpService;
    protected AuthService $authService;

    public function __construct(OtpService $otpService, AuthService $authService)
    {
        $this->otpService = $otpService;
        $this->authService = $authService;
    }

    public function sendOtp(OtpSendValidator $request): JsonResponse{
        $dto = new OtpSendDTO($request->validated());
        $this->otpService->sendOtp($dto);
        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully!'
        ]);
    }

    public function verifyOtp(OtpVerifyValidator $request){
        $dto = new OtpVerifyDTO($request->validated());
        if(!$this->otpService->verifyOtp($dto)){
            throw ValidationException::withMessages(['otp' => 'Invalid or Expired OTP']);
        }

        $token = $this->authService->registerOrLogin($dto);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_at' => auth('api')->factory()->getTTL() * 60,
        ]);
    }


}
