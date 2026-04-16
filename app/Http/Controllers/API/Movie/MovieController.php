<?php

namespace App\Http\Controllers\API\Movie;

use App\Application\Movie\Services\MovieService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class MovieController extends Controller
{
    /**
     * @var MovieService
     */
    private MovieService $movieService;

    /**
     * MovieController constructor.
     *
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Get all movies with optional filters
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Get movie by ID
     *
     * @param string $id
     * @return JsonResponse
     */
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
