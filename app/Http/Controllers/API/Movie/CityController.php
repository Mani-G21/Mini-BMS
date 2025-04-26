<?php

namespace App\Http\Controllers\API\Movie;

use App\Application\Movie\Services\CityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(Request $request): JsonResponse{
        $filters = $request->only(['include_inactive']);
        $cities = $this->cityService->getAllCities($filters);
        return response()->json($cities);
    }

    public function show(string $id): JsonResponse{
        $city = $this->cityService->getCityById($id);

        if(!$city){
            return response()->json([
                'message' => 'City not found',
            ], 404);
        }

        return response()->json($city);
    }
}
