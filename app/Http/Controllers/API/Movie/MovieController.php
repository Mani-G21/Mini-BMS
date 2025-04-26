<?php

namespace App\Http\Controllers\API\Movie;

use App\Application\Movie\Services\MovieService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search',
            'city',
            'genre',
            'language',
            'status',
            'per_page'
        ]);

        $movies = $this->movieService->getAllMovies($filters);

        return response()->json($movies);
    }

    public function show(string $id): JsonResponse
    {
        $movie = $this->movieService->getMovieById($id);

        if (!$movie) {
            return response()->json([
                'message' => 'Movie not found'
            ], 404);
        }

        return response()->json($movie);
    }

}
