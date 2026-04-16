<?php

namespace App\Domain\Movie\Repositories;

use App\Domain\Movie\Entities\City;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CityRepositoryInterface
{
    /**
     * Get all cities
     *
     * @param array $filters
     * @return Collection
     */
    public function getAllCities(array $filters = []): Collection;

    /**
     * Find a city by ID
     *
     * @param string $id
     * @return City|null
     */
    public function findById(string $id): ?City;

    /**
     * Create a new city
     *
     * @param array $data
     * @return City
     */
    public function create(array $data): City;

    /**
     * Update an existing city
     *
     * @param string $id
     * @param array $data
     * @return City|null
     */
    public function update(string $id, array $data): ?City;

    /**
     * Delete a city
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
