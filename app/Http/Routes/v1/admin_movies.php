<?php

use App\Http\Controllers\API\Admin\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->group(function() {
    Route::post('movies', [MovieController::class, 'store']);
    Route::put('movies/{id}', [MovieController::class, 'update']);
});
