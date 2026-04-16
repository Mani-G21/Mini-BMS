<?php

namespace App\Application\Seat\Services;

use App\Application\Seat\DTOs\SeatDTO;
use App\Domain\Seat\Repositories\SeatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SeatService
{
    public function __construct(
        private readonly SeatRepositoryInterface $seatRepository
    ) {
    }

    /**
     * Create a single seat
     */
    public function createSeat(SeatDTO $seatDTO): SeatDTO
    {
        $createdSeat = $this->seatRepository->create($seatDTO);
        return SeatDTO::fromArray($createdSeat->toEntityArray());
    }

    /**
     * Create multiple seats
     */
    public function createManySeats(array $seatDTOs): array
    {
        $createdSeats = $this->seatRepository->createMany($seatDTOs);

        return array_map(function ($seat) {
            return SeatDTO::fromArray($seat->toEntityArray());
        }, $createdSeats);
    }

    /**
     * Get all seats for a theater with pagination
     *
     * @param string $theaterId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getTheaterSeats(string $theaterId, int $perPage = 15): LengthAwarePaginator
    {
        $paginatedSeats = $this->seatRepository->getAllByTheaterId($theaterId, $perPage);

        // Transform the data in the paginator to DTOs
        $paginatedSeats->setCollection(
            $paginatedSeats->getCollection()->map(function ($seat) {
                return SeatDTO::fromArray($seat->toEntityArray());
            })
        );

        return $paginatedSeats;
    }

    /**
     * Update a seat
     */
    public function updateSeat(string $seatId, SeatDTO $seatDTO): ?SeatDTO
    {
        $updatedSeat = $this->seatRepository->update($seatId, $seatDTO);

        if (!$updatedSeat) {
            return null;
        }

        return SeatDTO::fromArray($updatedSeat->toEntityArray());
    }

    /**
     * Delete/deactivate a seat
     */
    public function deleteSeat(string $seatId): bool
    {
        return $this->seatRepository->delete($seatId);
    }

    /**
     * Get a seat by ID
     */
    public function getSeatById(string $seatId): ?SeatDTO
    {
        $seat = $this->seatRepository->findById($seatId);

        if (!$seat) {
            return null;
        }

        return SeatDTO::fromArray($seat->toEntityArray());
    }
}

