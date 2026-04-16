<?php

namespace App\Infrastructure\Movie\Repositories;

use App\Application\Movie\DTOs\MovieDTO;
use App\Domain\Movie\Entities\Movie;
use App\Domain\Movie\Repositories\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @var Movie
     */
    private Movie $movie;

    /**
     * MovieRepository constructor.
     *
     * @param Movie $movie
     */
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * @inheritDoc
     */
    public function getAllMovies(array $filters = []): LengthAwarePaginator
    {
        $query = $this->movie->newQuery()->with('cities');

        // Apply search filter if provided
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereFullText(['title', 'description'], $search);
        }

        // Filter by city
        if (isset($filters['city']) && !empty($filters['city'])) {
            $query->whereHas('cities', function (Builder $query) use ($filters) {
                $query->where('cities.id', $filters['city']);
            });
        }

        // Filter by genre
        if (isset($filters['genre']) && !empty($filters['genre'])) {
            $query->where('genre', $filters['genre']);
        }

        // Filter by language
        if (isset($filters['language']) && !empty($filters['language'])) {
            $query->where('language', $filters['language']);
        }

        // Filter by status
        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): ?Movie
    {
        return $this->movie->with('cities')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(MovieDTO $movieDTO): Movie
    {
        $data = [
            'title' => $movieDTO->title,
            'description' => $movieDTO->description,
            'trailer_url' => $movieDTO->trailer_url,
            'poster_url' => $movieDTO->poster_url,
            'release_date' => $movieDTO->release_date,
            'duration' => $movieDTO->duration,
            'language' => $movieDTO->language,
            'genre' => $movieDTO->genre,
            'rating' => $movieDTO->rating,
            'status' => $movieDTO->status,
        ];

        $movie = $this->movie->create($data);

        if (!empty($movieDTO->cities)) {
            $cityIds = array_column($movieDTO->cities, 'id');
            $movie->cities()->sync($cityIds);
        }

        return $movie->fresh('cities');

    }

    /**
     * @inheritDoc
     */
    public function update(string $id, MovieDTO $movieDTO): ?Movie
    {
        $movie = $this->movie->find($id);

        if (!$movie) {
            return null;
        }

        $data = [
            'title' => $movieDTO->title,
            'description' => $movieDTO->description,
            'trailer_url' => $movieDTO->trailer_url,
            'poster_url' => $movieDTO->poster_url,
            'release_date' => $movieDTO->release_date,
            'duration' => $movieDTO->duration,
            'language' => $movieDTO->language,
            'genre' => $movieDTO->genre,
            'rating' => $movieDTO->rating,
            'status' => $movieDTO->status,
        ];

        $movie->update($data);

        if (!empty($movieDTO->cities)) {
            $cityIds = array_column($movieDTO->cities, 'id');
            $movie->cities()->sync($cityIds);
        }

        return $movie->fresh('cities');
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): bool
    {
        $movie = $this->movie->find($id);

        if (!$movie) {
            return false;
        }

        return $movie->delete();
    }
}

