<?php

namespace App\Application\Show\Services;

use App\Domain\Show\Entities\Show;
use App\Application\Show\DTOs\ShowDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Show\Repositories\ShowRepositoryInterface;

class ShowService
{
    public function __construct(private ShowRepositoryInterface $showRepository)
    {}

    public function getAllShows(int $perPage = 15): LengthAwarePaginator
    {
        return $this->showRepository->getAllPaginated($perPage);
    }

    public function getShowById(string $id): ?Show
    {
        return $this->showRepository->findById($id);
    }

    public function createShow(ShowDTO $showDTO): Show
    {
        return $this->showRepository->create($showDTO);
    }

    public function updateShow(string $id, ShowDTO $showDTO): ?Show
    {
        return $this->showRepository->update($id, $showDTO);
    }

    public function deleteShow(string $id): bool
    {
        return $this->showRepository->delete($id);
    }
}
