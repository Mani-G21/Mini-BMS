<?php

namespace App\Application\Theater\Services;

use App\Domain\Theater\Entities\Theater;
use App\Application\Theater\DTOs\TheaterDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Theater\Repositories\TheaterRepositoryInterface;

class TheaterService
{
    public function __construct(
        private TheaterRepositoryInterface $theaterRepository
    ) {}

    public function getAllTheaters(int $perPage = 15): LengthAwarePaginator
    {
        return $this->theaterRepository->getAllPaginated($perPage);
    }

    public function getTheaterById(string $id): ?Theater
    {
        return $this->theaterRepository->findById($id);
    }

    public function createTheater(TheaterDTO $theaterDTO): Theater
    {
        return $this->theaterRepository->create($theaterDTO);
    }

    public function updateTheater(string $id, TheaterDTO $theaterDTO): ?Theater
    {
        return $this->theaterRepository->update($id, $theaterDTO);
    }

    public function deleteTheater(string $id): bool
    {
        return $this->theaterRepository->delete($id);
    }
}

