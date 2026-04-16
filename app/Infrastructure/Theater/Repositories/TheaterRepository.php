<?php

namespace App\Infrastructure\Theater\Repositories;

use App\Domain\Theater\Entities\Theater;
use App\Application\Theater\DTOs\TheaterDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Theater\Repositories\TheaterRepositoryInterface;

class TheaterRepository implements TheaterRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Theater::with('city')->paginate($perPage);
    }

    public function findById(string $id): ?Theater
    {
        return Theater::with('city')->find($id);
    }

    public function create(TheaterDTO $theaterDTO): Theater
    {
        return Theater::create($theaterDTO->toArray());

    }

    public function update(string $id, TheaterDTO $theaterDTO): ?Theater
    {
        $theater = $this->findById($id);

        if (!$theater) {
            return null;
        }

        $theater->update($theaterDTO->toArray());
        return $theater->fresh();

    }

    public function delete(string $id): bool
    {
        $theater = $this->findById($id);

        if (!$theater) {
            return false;
        }

        return $theater->delete();

    }
}

