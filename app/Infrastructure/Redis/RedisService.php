<?php

namespace App\Infrastructure\Redis;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class RedisService
{
    protected function getRedisKey(string $showId): string
    {
        return "locked_seats:{$showId}";
    }

    /**
     * Attempt to lock a seat for a user.
     */
    public function lockSeat(string $showId, string $seatId, string $userId, int $expiresInMinutes = 5): bool
    {
        Log::debug("Locking seat {$seatId} for user {$userId}");
        $key = $this->getRedisKey($showId);
        $now = Carbon::now();
        $expiresAt = $now->copy()->addMinutes($expiresInMinutes);

        $existingLock = Redis::hget($key, $seatId);
        if ($existingLock) {
            $data = json_decode($existingLock, true);
            $existingExpiry = Carbon::parse($data['expires_at']);
            if ($existingExpiry->isFuture() && $data['user_id'] !== $userId) {
                return false; // Already locked by someone else
            }
        }

        $seatData = json_encode([
            'user_id' => $userId,
            'locked_at' => $now->toIso8601String(),
            'expires_at' => $expiresAt->toIso8601String()
        ]);

        Redis::hset($key, $seatId, $seatData);

        return true;
    }

    /**
     * Check if a seat is currently locked (not expired).
     */
    public function isSeatLocked(string $showId, string $seatId): bool
    {
        $key = $this->getRedisKey($showId);
        $data = Redis::hget($key, $seatId);

        if (!$data) return false;

        $lockData = json_decode($data, true);
        $expiresAt = Carbon::parse($lockData['expires_at']);

        if ($expiresAt->isPast()) {
            Redis::hdel($key, $seatId); // Clean up
            return false;
        }

        return true;
    }

    /**
     * Get all locked (non-expired) seat IDs for a show.
     */
    public function getLockedSeatsByShowId(string $showId): array
    {
        $key = $this->getRedisKey($showId);

        $allLocks = Redis::hgetall($key);

        $now = CarbonImmutable::now();
        $lockedSeats = [];
        $expiredSeats = [];

        foreach ($allLocks as $seatId => $jsonData) {
            $lockData = json_decode($jsonData, true); //deserialiations to array
            $expiresAtStr = $lockData['expires_at'] ?? null;

            if ($expiresAtStr && CarbonImmutable::parse($expiresAtStr)->isAfter($now)) {
                $lockedSeats[] = $seatId;
            } else {
                $expiredSeats[] = $seatId;
            }
        }

        if (!empty($expiredSeats)) {
            Redis::hdel($key, ...$expiredSeats);
        }

        return $lockedSeats;
    }

    /**
     * Unlock a seat (force release), optionally only if owned by a specific user.
     */
    public function unlockSeat(string $showId, string $seatId, ?string $userId = null): bool
    {
        $key = $this->getRedisKey($showId);
        $data = Redis::hget($key, $seatId);

        if (!$data) return false;

        $lockData = json_decode($data, true);

        if ($userId && $lockData['user_id'] !== $userId) {
            return false; // Not owned by this user
        }

        return Redis::hdel($key, $seatId) > 0;
    }

    /**
     * Check if the seat is locked by a specific user.
     */
    public function isSeatLockedByUser(string $showId, string $seatId, string $userId): bool
    {
        $key = $this->getRedisKey($showId);
        $data = Redis::hget($key, $seatId);

        if (!$data) return false;

        $lockData = json_decode($data, true);
        $expiresAt = Carbon::parse($lockData['expires_at']);

        return $lockData['user_id'] === $userId && $expiresAt->isFuture();
    }
}

