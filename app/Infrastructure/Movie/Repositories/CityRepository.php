<?php

namespace App\Infrastructure\Movie\Repositories;

use App\Domain\Movie\Entities\City;
use App\Domain\Movie\Repositories\CityRepositoryInterface;
use Illuminate\Support\Collection;

class CityRepository implements CityRepositoryInterface
{
    /**
     * @var City
     */
    private City $city;

    /**
     * CityRepository constructor.
     *
     * @param City $city
     */
    public function __construct(City $city)
    {
        $this->city = $city;
    }

    /**
     * @inheritDoc
     */
    public function getAllCities(array $filters = []): Collection
    {
        $query = $this->city->newQuery();

        // Filter active cities only by default
        if (!isset($filters['include_inactive'])) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): ?City
    {
        return $this->city->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): City
    {
        return $this->city->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, array $data): ?City
    {
        $city = $this->city->find($id);

        if (!$city) {
            return null;
        }

        $city->update($data);

        return $city->fresh();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): bool
    {
        $city = $this->city->find($id);

        if (!$city) {
            return false;
        }

        return $city->delete();
    }
}
