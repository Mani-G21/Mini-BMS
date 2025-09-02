<?php

use App\Http\Controllers\API\Admin\TheaterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('theaters', [TheaterController::class, 'index']);
    Route::get('theaters/{id}', [TheaterController::class, 'show']);
});
