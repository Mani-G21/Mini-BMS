<?php

namespace App\Infrastructure\Show\Repositories;

use App\Domain\Show\Entities\Show;
use App\Application\Show\DTOs\ShowDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Show\Repositories\ShowRepositoryInterface;

class ShowRepository implements ShowRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Show::with(['movie','theater'])->paginate($perPage);
    }

    public function findById(string $id): ?Show
    {
        return Show::with(['movie','theater'])->find($id);
    }

    public function create(ShowDTO $showDTO): Show
    {
        return Show::create($showDTO->toArray());
    }

    public function update(string $id, ShowDTO $showDTO): ?Show
    {
        $show = $this->findById($id);

        if (!$show) {
            return null;
        }

        $show->update($showDTO->toArray());
        return $show->fresh();

    }

    public function delete(string $id): bool
    {
        $show = $this->findById($id);

        if (!$show) {
            return false;
        }

        return $show->delete();
    }
}
