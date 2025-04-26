<?php
namespace App\Domain\Movie\Repositories;

use App\Application\Movie\DTOs\MovieDTO;
use App\Domain\Movie\Entities\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepositoryInterface{
    public function getAllMovies(array $filters = []) : LengthAwarePaginator;
    public function findById(string $id) : ?Movie;
    public function create(MovieDTO $data): Movie;
    public function update(string $id, MovieDTO $data):?Movie;
    public function delete(string $id): bool;
}