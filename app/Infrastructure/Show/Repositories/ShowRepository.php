<?php

namespace App\Infrastructure\Show\Repositories;

use App\Application\Show\DTOs\ShowDTO;
use App\Domain\Show\Entities\Show;
use App\Domain\Show\Repositories\ShowRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowRepository implements ShowRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Show::with(['movie', 'theater'])->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): ?Show
    {
        return Show::with(['movie', 'theater'])->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(ShowDTO $showDTO): Show
    {
        return Show::create($showDTO->toArray());
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, ShowDTO $showDTO): ?Show
    {
        $show = $this->findById($id);

        if (!$show) {
            return null;
        }

        $show->update($showDTO->toArray());
        return $show->fresh();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): bool
    {
        $show = $this->findById($id);

        if (!$show) {
            return false;
        }

        return $show->delete();
    }
}
