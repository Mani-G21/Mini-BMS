<?php

namespace App\Infrastructure\Movie\Repositories;

use App\Domain\Movie\Entities\City;
use App\Domain\Movie\Repositories\CityRepositoryInterface;
use Illuminate\Support\Collection;

class CityRepository implements CityRepositoryInterface{
    
    public function getAllCities(array $filters = []): Collection
    {
        $query = City::query();

        if (!isset($filters['include_inactive'])) {
            $query->where('is_active', true);
        } elseif ($filters['include_inactive'] === "false") {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    public function findById(string $id): ?City
    {
        return City::find($id);
    }


}