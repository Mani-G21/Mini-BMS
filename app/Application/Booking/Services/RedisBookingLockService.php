<?php

namespace App\Domain\Booking\Services;

use App\Domain\Booking\Repositories\BookingLockServiceInterface;
use App\Infrastructure\Redis\RedisService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisBookingLockService implements BookingLockServiceInterface
{
    public function __construct(
        private RedisService $redisService
    ) {
    }

    /**
     * Lock multiple seats for a show
     *
     * @param string $showId
     * @param array $seatIds
     * @param string $userId
     * @return array
     */
    public function lockSeats(string $showId, array $seatIds, string $userId): array
    {
        $results = [
            'success' => [],
            'failed' => []
        ];

        foreach ($seatIds as $seatId) {
            try {
                $locked = $this->redisService->lockSeat($showId, $seatId, $userId);
                if ($locked) {
                    $results['success'][] = $seatId;
                } else {
                    $results['failed'][] = [
                        'seat_id' => $seatId,
                        'reason' => 'Failed to lock seat'
                    ];
                }
            } catch (\Exception $e) {
                $results['failed'][] = [
                    'seat_id' => $seatId,
                    'reason' => 'Error locking seat: ' . $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Check if seats are locked
     *
     * @param string $showId
     * @param array $seatIds
     * @return array
     */
    public function getLockedSeats(string $showId, array $seatIds = []): array
    {
        Log::debug("Getting locked seats for show $showId");
        $allLockedSeats = $this->redisService->getLockedSeatsByShowId($showId);

        if (empty($seatIds)) {
            return $allLockedSeats;
        }

        return array_filter($allLockedSeats, function($seatId) use ($seatIds) {
            return in_array($seatId, $seatIds);
        });
    }

    public function getLock(string $key, string $seatId): ?array
    {
        $json = Redis::hget($key, $seatId);
        return $json ? json_decode($json, true) : null;
    }

    public function removeLock(string $key, string $seatId): void
    {
        Redis::hdel($key, $seatId);
    }
}
