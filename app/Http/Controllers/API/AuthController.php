<?php

namespace App\Http\Controllers\API;

use App\Application\Auth\DTOs\OtpSendDTO;
use App\Application\Auth\Validators\OtpSendValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Infrastructure\Auth\Services\OtpService;

class AuthController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(OtpSendValidator $request): JsonResponse{
        $dto = new OtpSendDTO($request->validated());
        $this->otpService->sendOtp($dto);
        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully!'
        ]);
    }
}
