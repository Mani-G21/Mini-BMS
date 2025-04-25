<?php

    use App\Http\Controllers\API\AuthController;
    use Illuminate\Support\Facades\Route;

    Route::prefix('auth')->group(function(){
        Route::post('otp/get', [AuthController::class, 'sendOtp']);
        Route::post('otp/verify', [AuthController::class, 'verifyOtp']);
        Route::post('refresh', [AuthController::class, 'refreshToken']);
    });

    Route::middleware('auth:api')->group(function(){
        Route::get('/me', function(){
            return response()->json([
                'message' => 'You are authenticated',
                'data' => [
                    'user' => auth('api')->user(),
                ],
            ]);
        });
    });

    Route::middleware(['auth:api', 'role:admin'])->group(function(){
        Route::get('/admin-only', function(){
            return response()->json([
                'message' => 'You are admin',
                'data' => [
                    'user' => \Illuminate\Support\Facades\Auth::user()
                ]
            ]);    
        });
    });
    