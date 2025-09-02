<?php

use App\Http\Controllers\API\Admin\ShowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:admin'])->middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('admin/shows', ShowController::class)->except(['index', 'show']);
});
