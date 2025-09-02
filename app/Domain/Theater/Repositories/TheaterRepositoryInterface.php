<?php
namespace App\Domain\Theater\Repositories;

use App\Application\Theater\DTOs\TheaterDTO;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Pagination\LengthAwarePaginator;

interface TheaterRepositoryInterface{
    public function getAllPaginated(int $perPage = 15) : LengthAwarePaginator;
    public function findById(string $id): ?Theater;
    public function create(TheaterDTO $theaterDTO) : Theater;
    public function update(string $id, TheaterDTO $theaterDTO) : ?Theater;
    public function delete(string $id) : bool;
}