<?php

namespace App\Http\Controllers\API\Admin;

use App\Application\Theater\DTOs\TheaterDTO;
use App\Application\Theater\Services\TheaterService;
use App\Domain\Theater\Validators\StoreTheaterRequest;
use App\Domain\Theater\Validators\UpdateTheaterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function __construct(
        private TheaterService $theaterService
    ) { }

    /**
     * Display a listing of the theaters.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $theaters = $this->theaterService->getAllTheaters($perPage);

        return response()->json([
            'data' => $theaters->items(),
            'meta' => [
                'current_page' => $theaters->currentPage(),
                'last_page' => $theaters->lastPage(),
                'per_page' => $theaters->perPage(),
                'total' => $theaters->total(),
            ],
        ]);
    }

    /**
     * Store a newly created theater in storage.
     */
    public function store(StoreTheaterRequest $request): JsonResponse
    {
        $theaterDTO = TheaterDTO::fromArray($request->validated());
        $theater = $this->theaterService->createTheater($theaterDTO);

        return response()->json([
            'message' => 'Theater created successfully',
            'data' => $theater
        ], 201);
    }

    /**
     * Display the specified theater.
     */
    public function show(string $id): JsonResponse
    {
        $theater = $this->theaterService->getTheaterById($id);

        if (!$theater) {
            return response()->json([
                'message' => 'Theater not found'
            ], 404);
        }

        return response()->json([
            'data' => $theater
        ]);
    }

    /**
     * Update the specified theater in storage.
     */
    public function update(UpdateTheaterRequest $request, string $id): JsonResponse
    {
        $theaterDTO = TheaterDTO::fromArray($request->validated());
        $theater = $this->theaterService->updateTheater($id, $theaterDTO);

        if (!$theater) {
            return response()->json([
                'message' => 'Theater not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Theater updated successfully',
            'data' => $theater
        ]);
    }

    /**
     * Remove the specified theater from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->theaterService->deleteTheater($id);

        if (!$result) {
            return response()->json([
                'message' => 'Theater not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Theater deleted successfully'
        ]);
    }

}
