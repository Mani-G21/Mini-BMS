<?php

use App\Http\Controllers\API\Admin\ShowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('shows', [ShowController::class, 'index']);
    Route::get('shows/{id}', [ShowController::class, 'show']);
});
