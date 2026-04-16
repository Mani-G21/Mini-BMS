<?php

namespace App\Http\Controllers\API\Admin;

use App\Application\Seat\DTOs\SeatDTO;
use App\Application\Seat\Services\SeatService;
use App\Domain\Seat\Validators\StoreSeatRequest;
use App\Domain\Seat\Validators\UpdateSeatRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeatController extends Controller
{
    public function __construct(
        private readonly SeatService $seatService
    ) {
    }

    public function store(StoreSeatRequest $request, string $theaterId): JsonResponse
    {
        $seatDTOs = array_map(function ($seatData) use ($theaterId) {
            return SeatDTO::fromArray([
                'theater_id' => $theaterId,
                'label' => $seatData['label'],
                'row' => $seatData['row'],
                'column' => $seatData['column'],
                'category' => $seatData['category'],
                'status' => $seatData['status'] ?? 'active',
            ]);
        }, $request->validated()['seats']);

        $createdSeats = $this->seatService->createManySeats($seatDTOs);

        return response()->json([
            'data' => array_map(fn (SeatDTO $seat) => $seat->toArray(), $createdSeats),
            'message' => 'Seats created successfully',
        ], Response::HTTP_CREATED);
    }

    public function index(Request $request, string $theaterId): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $paginatedSeats = $this->seatService->getTheaterSeats($theaterId, $perPage);
        return response()->json($paginatedSeats);
    }

    public function update(UpdateSeatRequest $request, string $seatId): JsonResponse
    {
        $currentSeat = $this->seatService->getSeatById($seatId);

        if (!$currentSeat) {
            return response()->json([
                'message' => 'Seat not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $updatedData = array_merge($currentSeat->toArray(), $request->validated());
        $seatDTO = SeatDTO::fromArray($updatedData);

        $updatedSeat = $this->seatService->updateSeat($seatId, $seatDTO);

        return response()->json([
            'data' => $updatedSeat->toArray(),
            'message' => 'Seat updated successfully',
        ]);
    }

    public function destroy(string $seatId): JsonResponse
    {
        $success = $this->seatService->deleteSeat($seatId);

        if (!$success) {
            return response()->json([
                'message' => 'Seat not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Seat deactivated successfully',
        ]);
    }
}

