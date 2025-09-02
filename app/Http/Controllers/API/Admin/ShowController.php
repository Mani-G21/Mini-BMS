<?php

namespace App\Http\Controllers\API\Admin;

use App\Application\Show\DTOs\ShowDTO;
use App\Application\Show\Services\ShowService;
use App\Domain\Show\Validators\StoreShowRequest;
use App\Domain\Show\Validators\UpdateShowRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __construct(
        private ShowService $showService
    ) { }

    /**
     * Display a listing of the shows.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $shows = $this->showService->getAllShows($perPage);

        return response()->json([
            'data' => $shows->items(),
            'meta' => [
                'current_page' => $shows->currentPage(),
                'last_page' => $shows->lastPage(),
                'per_page' => $shows->perPage(),
                'total' => $shows->total(),
            ],
        ]);
    }

    /**
     * Store a newly created show in storage.
     */
    public function store(StoreShowRequest $request): JsonResponse
    {
        $showDTO = ShowDTO::fromArray($request->validated());
        $show = $this->showService->createShow($showDTO);

        return response()->json([
            'message' => 'Show created successfully',
            'data' => $show
        ], 201);
    }

    /**
     * Display the specified show.
     */
    public function show(string $id): JsonResponse
    {
        $show = $this->showService->getShowById($id);

        if (!$show) {
            return response()->json([
                'message' => 'Show not found'
            ], 404);
        }

        return response()->json([
            'data' => $show
        ]);
    }

    /**
     * Update the specified show in storage.
     */
    public function update(UpdateShowRequest $request, string $id): JsonResponse
    {
        $showDTO = ShowDTO::fromArray($request->validated());
        $show = $this->showService->updateShow($id, $showDTO);

        if (!$show) {
            return response()->json([
                'message' => 'Show not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Show updated successfully',
            'data' => $show
        ]);
    }

    /**
     * Remove the specified show from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->showService->deleteShow($id);

        if (!$result) {
            return response()->json([
                'message' => 'Show not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Show deleted successfully'
        ]);
    }

}
