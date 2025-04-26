<?php
namespace App\Application\Movie\Services;

use App\Application\Movie\DTOs\MovieDTO;
use App\Domain\Movie\Exceptions\MovieNotFoundException;
use App\Domain\Movie\Repositories\MovieRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieService{
    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies(array $filters = []): LengthAwarePaginator
    {
        $movies = $this->movieRepository->getAllMovies($filters);
        return $movies->through(function ($movie) {
            return MovieDTO::fromModel($movie);
        });
    }

    public function getMovieById(string $id): ?MovieDTO
    {
        $movie = $this->movieRepository->findById($id);

        if (!$movie) {
            return null;
        }

        return MovieDTO::fromModel($movie);
    }

    public function createMovie(array $movieData): MovieDTO
    {
        $movieDTO = MovieDTO::fromRequest($movieData);
        $movie = $this->movieRepository->create($movieDTO);
        return MovieDTO::fromModel($movie);
    }

    public function updateMovie(string $id, MovieDTO $movieDTO): MovieDTO
    {
        $movie = $this->movieRepository->update($id, $movieDTO);
        if (!$movie) {
            throw new MovieNotFoundException("Movie with ID {$id} not found");
        }
        return MovieDTO::fromModel($movie);
    }


}