<?php

namespace App\Application\Movie\Services;

use App\Domain\Movie\Repositories\CityRepositoryInterface;
use Illuminate\Support\Collection;

class CityService
{
    /**
     * @var CityRepositoryInterface
     */
    private CityRepositoryInterface $cityRepository;

    /**
     * CityService constructor.
     *
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get all cities
     *
     * @param array $filters
     * @return Collection
     */
    public function getAllCities(array $filters = []): Collection
    {
        return $this->cityRepository->getAllCities($filters);
    }

    /**
     * Get city by ID
     *
     * @param string $id
     * @return array|null
     */
    public function getCityById(string $id): ?array
    {
        $city = $this->cityRepository->findById($id);

        if (!$city) {
            return null;
        }

        return [
            'id' => $city->id,
            'name' => $city->name,
            'state' => $city->state,
            'country' => $city->country,
            'is_active' => $city->is_active,
        ];
    }
}
