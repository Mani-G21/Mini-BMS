<?php

namespace App\Application\Movie\Services;

use App\Domain\Movie\Repositories\CityRepositoryInterface;
use Illuminate\Support\Collection;

class CityService{
    
    private CityRepositoryInterface $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAllCities($filters = []): Collection{
        return $this->cityRepository->getAllCities($filters);
    }

    public function getCityById(string $id): ?array{
        $city = $this->cityRepository->findById($id);

        if(!$city){
            return null;
        }

        return[
            'id' => $city->id,
            'name' => $city->name,
            'state' => $city->state,
            'country' => $city->country,
            'is_active' => $city->is_active,
        ];
    }
}