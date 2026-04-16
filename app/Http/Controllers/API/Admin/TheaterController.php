<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Application\Theater\DTOs\TheaterDTO;
use App\Application\Theater\Services\TheaterService;
use App\Domain\Theater\Validators\StoreTheaterRequest;
use App\Domain\Theater\Validators\UpdateTheaterRequest;

class TheaterController extends Controller
{
    public function __construct(
        private TheaterService $theaterService
    ) {}

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

    public function store(StoreTheaterRequest $request): JsonResponse
    {
        $theaterDTO = TheaterDTO::fromArray($request->validated());
        $theater = $this->theaterService->createTheater($theaterDTO);

        return response()->json([
            'message' => 'Theater created successfully',
            'data' => $theater
        ], 201);
    }

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
