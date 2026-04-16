<?php

namespace App\Http\Controllers\API\Movie;

use App\Application\Movie\Services\CityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @var CityService
     */
    private CityService $cityService;

    /**
     * CityController constructor.
     *
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Get all cities
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['include_inactive']);

        $cities = $this->cityService->getAllCities($filters);

        return response()->json($cities);
    }

    /**
     * Get city by ID
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $city = $this->cityService->getCityById($id);

        if (!$city) {
            return response()->json([
                'message' => 'City not found'
            ], 404);
        }

        return response()->json($city);
    }
}
