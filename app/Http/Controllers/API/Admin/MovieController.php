<?php

namespace App\Http\Controllers\API\Admin;

use App\Application\Movie\DTOs\MovieDTO;
use App\Application\Movie\Services\MovieService;
use App\Domain\Movie\Exceptions\MovieNotFoundException;
use App\Domain\Movie\Validators\StoreMovieRequest;
use App\Domain\Movie\Validators\UpdateMovieRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function __construct(
        private MovieService $movieService
    ) {}

    public function store(StoreMovieRequest $request): JsonResponse
    {
        try {
            $movieDTO = $this->movieService->createMovie($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Movie created successfully',
                'data' => $movieDTO
            ], 201);

        } catch (Exception $e) {
            Log::error('Failed to create movie: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->validated()
            ]);

           
            return response()->json([
                'success' => false,
                'message' => 'Failed to create movie',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
    public function update(UpdateMovieRequest $request, string $id): JsonResponse
    {
        try {
            $existingMovie = $this->movieService->getMovieById($id);
            if (!$existingMovie) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movie not found'
                ], 404);
            }

            $validatedData = $request->validated();
            $mergedData = array_merge([
                'id' => $id,
                'title' => $existingMovie->title,
                'description' => $existingMovie->description,
                'trailer_url' => $existingMovie->trailer_url,
                'poster_url' => $existingMovie->poster_url,
                'release_date' => $existingMovie->release_date,
                'duration' => $existingMovie->duration,
                'language' => $existingMovie->language,
                'genre' => $existingMovie->genre,
                'rating' => $existingMovie->rating,
                'status' => $existingMovie->status,
                'city_ids' => array_column($existingMovie->cities, 'id'),
            ], $validatedData);

            $movieDTO = new MovieDTO(
                id: $id,
                title: $mergedData['title'],
                description: $mergedData['description'],
                trailer_url: $mergedData['trailer_url'],
                poster_url: $mergedData['poster_url'],
                release_date: $mergedData['release_date'],
                duration: $mergedData['duration'],
                language: $mergedData['language'],
                genre: $mergedData['genre'],
                rating: $mergedData['rating'],
                status: $mergedData['status'],
                cities: isset($mergedData['city_ids']) ? array_map(fn($cityId) => ['id' => $cityId], $mergedData['city_ids']) : $existingMovie->cities
            );

            $updatedMovie = $this->movieService->updateMovie($id, $movieDTO);

            return response()->json([
                'success' => true,
                'message' => 'Movie updated successfully',
                'data' => $updatedMovie
            ], 200);

        } catch (MovieNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);

        } catch (Exception $e) {
            Log::error('Failed to update movie: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->validated(),
                'movie_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update movie',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
}
