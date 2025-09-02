<?php

namespace App\Domain\Show\Repositories;

use App\Application\Show\DTOs\ShowDTO;
use App\Domain\Show\Entities\Show;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShowRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function findById(string $id): ?Show;
    public function create(ShowDTO $showDTO): Show;
    public function update(string $id, ShowDTO $showDTO): ?Show;
    public function delete(string $id): bool;
}
