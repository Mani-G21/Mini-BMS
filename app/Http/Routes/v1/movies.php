<?php

use App\Http\Controllers\API\Movie\CityController;
use App\Http\Controllers\API\Movie\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{id}', [MovieController::class, 'show']);
});

Route::prefix('cities')->group(function () {
    Route::get('/', [CityController::class, 'index']);
    Route::get('/{id}', [CityController::class, 'show']);
});
