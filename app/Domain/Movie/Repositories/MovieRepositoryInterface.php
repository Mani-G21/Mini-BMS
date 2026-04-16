<?php

namespace App\Domain\Movie\Repositories;

use App\Application\Movie\DTOs\MovieDTO;
use App\Domain\Movie\Entities\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepositoryInterface
{
    /**
     * Get all movies with optional filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllMovies(array $filters = []): LengthAwarePaginator;

    /**
     * Find a movie by ID
     *
     * @param string $id
     * @return Movie|null
     */
    public function findById(string $id): ?Movie;

    /**
     * Create a new movie
     *
     * @param MovieDTO $movieDTO
     * @return Movie
     */
    public function create(MovieDTO $movieDTO): Movie;

    /**
     * Update an existing movie
     *
     * @param string $id
     * @param MovieDTO $movieDTO
     * @return Movie|null
     */
    public function update(string $id, MovieDTO $movieDTO): ?Movie;

    /**
     * Delete a movie
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
