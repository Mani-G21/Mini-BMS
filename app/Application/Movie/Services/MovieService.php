<?php

namespace App\Application\Movie\Services;

use App\Application\Movie\DTOs\MovieDTO;
use App\Domain\Movie\Repositories\MovieRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieService
{
    /**
     * @var MovieRepositoryInterface
     */
    private MovieRepositoryInterface $movieRepository;

    /**
     * MovieService constructor.
     *
     * @param MovieRepositoryInterface $movieRepository
     */
    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * Get all movies with optional filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllMovies(array $filters = []): LengthAwarePaginator
    {
        $movies = $this->movieRepository->getAllMovies($filters);
        return $movies->through(function ($movie) {
            return MovieDTO::fromModel($movie);
        });
    }

    /**
     * Get movie by ID
     *
     * @param string $id
     * @return MovieDTO|null
     */
    public function getMovieById(string $id): ?MovieDTO
    {
        $movie = $this->movieRepository->findById($id);

        if (!$movie) {
            return null;
        }

        return MovieDTO::fromModel($movie);
    }

    /**
     * Create a new movie
     *
     * @param array $movieData
     * @return MovieDTO
     */
    public function createMovie(array $movieData): MovieDTO
    {
        $movieDTO = MovieDTO::fromRequest($movieData);
        $movie = $this->movieRepository->create($movieDTO);
        return MovieDTO::fromModel($movie);
    }

    public function updateMovie(string $id, MovieDTO $movieDTO): MovieDTO
    {
        $movie = $this->movieRepository->update($id, $movieDTO);

        // If movie not found, throw exception
        if (!$movie) {
            throw new MovieNotFoundException("Movie with ID {$id} not found");
        }
        return MovieDTO::fromModel($movie);
    }
}

