<?php

namespace App\Domain\Booking\Repositories;

use App\Domain\Booking\Entities\Booking;

interface BookingRepositoryInterface
{
    /**
     * Get all booked seats for a specific show
     *
     * @param string $showId
     * @return array
     */
    public function getBookedSeatsByShowId(string $showId): array;

    /**
     * Get all locked seat IDs for a specific show
     *
     * @param string $showId
     * @return array
     */
    public function getLockedSeatsByShowId(string $showId): array;

    public function areSeatsBooked(string $showId, array $seatIds): array;

    public function createBooking(array $data): Booking;

    public function attachSeats(string $bookingId, array $seatIds): void;
}

