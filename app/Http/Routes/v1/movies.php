<?php

use App\Http\Controllers\API\Movie\CityController;
use App\Http\Controllers\API\Movie\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Movie API Routes (v1)
|--------------------------------------------------------------------------
|
| Here is where you can register movie API routes for your application.
|
*/

Route::prefix('movies')->group(function () {
    // Movie Routes
    Route::get('/', [MovieController::class, 'index']); // List movies with filtering
    Route::get('/{id}', [MovieController::class, 'show']); // Get movie details
});

Route::prefix('cities')->group(function () {
    // City Routes
    Route::get('/', [CityController::class, 'index']); // List cities
    Route::get('/{id}', [CityController::class, 'show']); // Get city details
});

