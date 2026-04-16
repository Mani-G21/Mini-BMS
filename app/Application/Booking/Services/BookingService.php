<?php

namespace App\Application\Booking\Services;

use App\Application\Booking\DTOs\SeatMapDTO;
use App\Domain\Booking\Entities\Booking;
use App\Domain\Booking\Repositories\BookingLockServiceInterface;
use App\Domain\Booking\Repositories\BookingRepositoryInterface;
use App\Domain\Seat\Repositories\SeatRepositoryInterface;
use App\Domain\Show\Repositories\ShowRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;

class BookingService
{
    public function __construct(
        private SeatRepositoryInterface $seatRepository,
        private BookingRepositoryInterface $bookingRepository,
        private ShowRepositoryInterface $showRepository,
        private BookingLockServiceInterface $bookingLockService
    ) {
    }

    /**
     * Get seat map for a specific show
     *
     * @param string $showId
     * @return array
     */
    public function getSeatMapForShow(string $showId): array
    {
        Log::debug("Getting seat map for show $showId");
        // Get the show to find the theater
        $show = $this->showRepository->findById($showId);
        if (!$show) {
            throw new \InvalidArgumentException("Show not found");
        }

        // Get all seats for the theater
        $theaterSeats = $this->seatRepository->getAllByTheaterId($show['theater_id']);

        // Get booked and locked seats
        $bookedSeatIds = $this->bookingRepository->getBookedSeatsByShowId($showId);
        Log::debug("Going to fetch locked seats for show $showId.");
        $lockedSeatIds = $this->bookingRepository->getLockedSeatsByShowId($showId);

        // Create seat map with status information
        $seatMap = [];
        foreach ($theaterSeats as $seat) {
            $status = 'available';

            if (in_array($seat['id'], $bookedSeatIds)) {
                $status = 'booked';
            } elseif (in_array($seat['id'], $lockedSeatIds)) {
                $status = 'locked';
            }

            $seatMap[] = new SeatMapDTO(
                seat_id: $seat['id'],
                label: $seat['label'],
                row: $seat['row'],
                column: $seat['column'],
                category: $seat['category'],
                status: $status
            );
        }

        return array_map(fn(SeatMapDTO $seat) => $seat->toArray(), $seatMap);
    }

    /**
     * Lock seats for a user in a specific show
     *
     * @param string $showId
     * @param array $seatIds
     * @param string $userId
     * @return array
     */
    public function lockSeats(string $showId, array $seatIds, string $userId): array
    {
        // Validate maximum seats
        if (count($seatIds) > 5) {
            return [
                'success' => [],
                'failed' => array_map(fn($seatId) => [
                    'seat_id' => $seatId,
                    'reason' => 'Maximum 5 seats allowed per request'
                ], $seatIds)
            ];
        }

        // Get the show to find the theater
        $show = $this->showRepository->findById($showId);
        if (!$show) {
            throw new \InvalidArgumentException("Show not found");
        }

        // Get theater seats to validate they exist
        $theaterSeats = $this->seatRepository->getAllByTheaterId($show['theater_id']);
        $theaterSeatIds = array_column($theaterSeats->items(), 'id');

        // Get already booked seats
        $bookedSeatIds = $this->bookingRepository->getBookedSeatsByShowId($showId);

        // Get already locked seats
        $lockedSeatIds = $this->bookingRepository->getLockedSeatsByShowId($showId);

        // Validate seat availability
        $validSeats = [];
        $failedSeats = [];

        foreach ($seatIds as $seatId) {
            // Check if the seat exists in the theater
            if (!in_array($seatId, $theaterSeatIds)) {
                $failedSeats[] = [
                    'seat_id' => $seatId,
                    'reason' => 'Seat does not exist in this theater'
                ];
                continue;
            }

            // Check if the seat is already booked
            if (in_array($seatId, $bookedSeatIds)) {
                $failedSeats[] = [
                    'seat_id' => $seatId,
                    'reason' => 'Seat is already booked'
                ];
                continue;
            }

            // Check if the seat is already locked
            if (in_array($seatId, $lockedSeatIds)) {
                $failedSeats[] = [
                    'seat_id' => $seatId,
                    'reason' => 'Seat is already locked'
                ];
                continue;
            }

            $validSeats[] = $seatId;
        }

        // If no valid seats, return early
        if (empty($validSeats)) {
            return [
                'success' => [],
                'failed' => $failedSeats
            ];
        }

        // Lock valid seats using Redis
        $lockResult = $this->bookingLockService->lockSeats($showId, $validSeats, $userId);

        // Combine results
        return [
            'success' => $lockResult['success'],
            'failed' => array_merge($failedSeats, $lockResult['failed'])
        ];
    }

    public function confirmBooking(string $userId, array $data): Booking
    {
        $showId = $data['show_id'];
        $seatIds = $data['locked_seat_ids'];

        // 1. Validate Stripe payment
        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::retrieve($data['payment_id']);
        if ($intent->status !== 'succeeded' || $intent->metadata['user_id'] !== $userId) {
            throw new \Exception('Payment validation failed.');
        }

        // 2. Check Redis lock
        $lockKey = "locked_seats:$showId";
        foreach ($seatIds as $seatId) {
            $lockData = $this->bookingLockService->getLock($lockKey, $seatId);
            if (!$lockData || $lockData['user_id'] !== $userId) {
                throw new \Exception("Seat $seatId not locked by user.");
            }
        }

        // 3. Ensure seats not already booked
        $alreadyBooked = $this->bookingRepository->areSeatsBooked($showId, $seatIds);
        if (!empty($alreadyBooked)) {
            throw new \Exception("Some seats are already booked.");
        }

        // 4. Persist Booking
        return DB::transaction(function () use ($userId, $showId, $seatIds, $intent, $lockKey) {

            $booking = $this->bookingRepository->createBooking([
                'user_id'     => $userId,
                'show_id'     => $showId,
                'status' => 'confirmed',
                'payment_id'  => $intent->id,
                'total_amount' => $intent->amount_received,
            ]);

            $this->bookingRepository->attachSeats($booking->id, $seatIds);

            foreach ($seatIds as $seatId) {
                $this->bookingLockService->removeLock($lockKey, $seatId);
            }

            return $booking;
        });
    }

}
