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

        $newToken = $this->authService->registerOrLogin($dto);
        return $this->respondWithToken($newToken);
    }

    public function respondWithToken(string $token): JsonResponse{
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Refreshes the current token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        // The 'auth:api' middleware ensures the user is authenticated.
        // The refresh method automatically invalidates the old token (adds it to the blacklist).
        $newToken = $this->authService->refreshToken();
        return $this->respondWithToken($newToken);
    }




}
