<?php

use App\Http\Controllers\Api\V1\BookingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/shows/{id}/seats', [BookingController::class, 'getAvailableSeats']);
    Route::post('shows/{id}/lock-seats', [BookingController::class, 'lockSeats']);
    Route::post('bookings/confirm', [BookingController::class, 'confirmBooking']);
});
