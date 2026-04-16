<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Booking\Services\BookingService;
use App\Domain\Booking\Validators\LockSeatsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {
    }

    /**
     * Get available seats for a show
     *
     * @param Request $request
     * @param string $id Show ID
     * @return JsonResponse
     */
    public function getAvailableSeats(Request $request, string $id): JsonResponse
    {
        try {
            $seatMap = $this->bookingService->getSeatMapForShow($id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'seats' => $seatMap
                ]
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::debug('Failed to get seat map for show: ' . $e->getMessage());
            Log::debug($e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the seat map'
            ], 500);
        }
    }

    /**
     * Lock seats for a user in a specific show
     *
     * @param LockSeatsRequest $request
     * @param string $id Show ID
     * @return JsonResponse
     */
    public function lockSeats(LockSeatsRequest $request, string $id): JsonResponse
    {
        try {
            $userId = Auth::id();
            $validated = $request->validated();
            $result = $this->bookingService->lockSeats($id, $validated['seat_ids'], $userId);

            if (empty($result['success'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to lock any seats',
                    'data' => [
                        'failed_seats' => $result['failed']
                    ]
                ], 422);
            }

            return response()->json([
                'status' => 'success',
                'message' => count($result['success']) . ' seat(s) locked successfully',
                'data' => [
                    'locked_seats' => $result['success'],
                    'failed_seats' => $result['failed']
                ]
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while locking seats'
            ], 500);
        }
    }

    public function confirmBooking(Request $request)
    {
        $data = $request->validate([
            'show_id'           => 'required|uuid',
            'locked_seat_ids'   => 'required|array',
            'locked_seat_ids.*' => 'uuid',
            'payment_id'        => 'required|string'
        ]);

        $booking = $this->bookingService->confirmBooking(auth()->id(), $data);

        return response()->json(['booking_id' => $booking->id], 201);
    }
}
