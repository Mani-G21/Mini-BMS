<?php

namespace App\Infrastructure\Booking\Repositories;

use App\Domain\Booking\Entities\Booking;
use App\Domain\Booking\Repositories\BookingRepositoryInterface;
use App\Infrastructure\Redis\RedisService;
use Illuminate\Support\Facades\DB;

class BookingRepository implements BookingRepositoryInterface
{
    public function __construct(
        private RedisService $redisService
    ) {
    }
    /**
     * Get all booked seats for a specific show
     *
     * @param string $showId
     * @return array
     */
    public function getBookedSeatsByShowId(string $showId): array
    {
        $bookedSeats = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('bookings.show_id', $showId)
            ->where('bookings.status', 'confirmed')
            ->select('booking_seats.seat_id')
            ->get()
            ->pluck('seat_id')
            ->toArray();

        return $bookedSeats;
    }

    /**
     * Get all locked seats for a specific show from Redis
     *
     * @param string $showId
     * @return array
     */
    public function getLockedSeatsByShowId(string $showId): array
    {
        return $this->redisService->getLockedSeatsByShowId($showId);
    }

    public function areSeatsBooked(string $showId, array $seatIds): array
    {
        return DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('bookings.show_id', $showId)
            ->whereIn('booking_seats.seat_id', $seatIds)
            ->pluck('seat_id')
            ->toArray();
    }

    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
    }

    public function attachSeats(string $bookingId, array $seatIds): void
    {
        $data = array_map(fn($id) => [
            'booking_id' => $bookingId,
            'seat_id'    => $id,
            'created_at' => now(),
            'updated_at' => now(),
        ], $seatIds);

        DB::table('booking_seats')->insert($data);
    }
}
