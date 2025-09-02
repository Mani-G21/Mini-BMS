<?php

namespace App\Infrastructure\Theater\Repositories;

use App\Application\Theater\DTOs\TheaterDTO;
use App\Domain\Theater\Entities\Theater;
use App\Domain\Theater\Repositories\TheaterRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TheaterRepository implements TheaterRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Theater::with('city')->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): ?Theater
    {
        return Theater::with('city')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(TheaterDTO $theaterDTO): Theater
    {
        return Theater::create($theaterDTO->toArray());
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, TheaterDTO $theaterDTO): ?Theater
    {
        $theater = $this->findById($id);

        if (!$theater) {
            return null;
        }

        $theater->update($theaterDTO->toArray());
        return $theater->fresh();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): bool
    {
        $theater = $this->findById($id);

        if (!$theater) {
            return false;
        }

        return $theater->delete();
    }
}
