<?php

namespace App\Domain\Movie\Repositories;

use App\Domain\Movie\Entities\City;
use Illuminate\Support\Collection;

interface CityRepositoryInterface{
    public function getAllCities(array $filters = []): Collection;
    public function findById(string $id): ?City;
    public function create(array $data): City;
    public function update(string $id, array $data): ?City;
    public function delete(string $id): bool;
}