<?php

namespace App\Domain\Booking\Repositories;

interface BookingLockServiceInterface
{
    /**
     * Lock multiple seats for a show
     *
     * @param string $showId
     * @param array $seatIds
     * @param string $userId
     * @return array
     */
    public function lockSeats(string $showId, array $seatIds, string $userId): array;

    /**
     * Check if seats are locked
     *
     * @param string $showId
     * @param array $seatIds
     * @return array
     */
    public function getLockedSeats(string $showId, array $seatIds = []): array;
}

