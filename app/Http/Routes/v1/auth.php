<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

    Route::prefix('auth')->group(function(){
        Route::post('otp/get', [AuthController::class, 'sendOtp']);
    })
?>