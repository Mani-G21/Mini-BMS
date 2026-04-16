<?php

namespace App\Domain\Seat\Repositories;

use App\Application\Seat\DTOs\SeatDTO;
use App\Domain\Seat\Entities\Seat;
use Illuminate\Pagination\LengthAwarePaginator;

interface SeatRepositoryInterface
{
    /**
     * Find a seat by ID
     *
     * @param string $id The seat ID
     * @return Seat|null The seat entity or null if not found
     */
    public function findById(string $id): ?Seat;

    /**
     * Get all seats for a theater with pagination
     *
     * @param string $theaterId The theater ID
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator Paginated list of seats
     */
    public function getAllByTheaterId(string $theaterId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Create a new seat
     *
     * @param SeatDTO $seatDTO The seat DTO with data to create
     * @return Seat The created seat entity
     */
    public function create(SeatDTO $seatDTO): Seat;

    /**
     * Create multiple seats at once
     *
     * @param array $seatDTOs Array of seat DTOs
     * @return array Array of created seat entities
     */
    public function createMany(array $seatDTOs): array;

    /**
     * Update an existing seat
     *
     * @param string $id The seat ID to update
     * @param SeatDTO $seatDTO The seat DTO with updated values
     * @return Seat|null The updated seat entity or null if not found
     */
    public function update(string $id, SeatDTO $seatDTO): ?Seat;

    /**
     * Deactivate a seat (change status to inactive)
     *
     * @param string $id The seat ID
     * @return bool True if successful, false otherwise
     */
    public function delete(string $id): bool;
}

