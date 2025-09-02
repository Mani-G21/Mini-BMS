<?php

use App\Http\Controllers\API\Admin\TheaterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('admin/theaters', TheaterController::class)->except(['index', 'show']);
});
