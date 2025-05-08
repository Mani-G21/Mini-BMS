<?php

namespace App\Domain\Movie\Repositories;

use App\Domain\Movie\Entities\City;
use Illuminate\Support\Collection;

interface CityRepositoryInterface{
    public function getAllCities(array $filters = []): Collection;
    public function findById(string $id): ?City;
}