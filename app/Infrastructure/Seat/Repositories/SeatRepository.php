<?php

namespace App\Infrastructure\Seat\Repositories;

use App\Application\Seat\DTOs\SeatDTO;
use App\Domain\Seat\Entities\Seat;
use App\Domain\Seat\Enums\SeatStatus;
use App\Domain\Seat\Repositories\SeatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SeatRepository implements SeatRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findById(string $id): ?Seat
    {
        return Seat::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getAllByTheaterId(string $theaterId, int $perPage = 15): LengthAwarePaginator
    {
        return Seat::where('theater_id', $theaterId)
            ->orderBy('row')
            ->orderBy('column')
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(SeatDTO $seatDTO): Seat
    {
        return Seat::create([
            'theater_id' => $seatDTO->theater_id,
            'label' => $seatDTO->label,
            'row' => $seatDTO->row,
            'column' => $seatDTO->column,
            'category' => $seatDTO->category,
            'status' => $seatDTO->status
        ]);
    }

    /**
     * @inheritDoc
     */
    public function createMany(array $seatDTOs): array
    {
        $createdSeats = [];

        foreach ($seatDTOs as $seatDTO) {
            $createdSeats[] = $this->create($seatDTO);
        }

        return $createdSeats;
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, SeatDTO $seatDTO): ?Seat
    {
        $seat = $this->findById($id);

        if (!$seat) {
            return null;
        }

        $seat->update([
            'label' => $seatDTO->label,
            'row' => $seatDTO->row,
            'column' => $seatDTO->column,
            'category' => $seatDTO->category,
            'status' => $seatDTO->status
        ]);

        return $seat->fresh();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): bool
    {
        $seat = $this->findById($id);

        if (!$seat) {
            return false;
        }

        $seat->update(['status' => SeatStatus::INACTIVE]);
        return true;
    }
}

