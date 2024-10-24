<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\BreweryRequest;
use App\Http\Resources\Brewery\Collection;
use App\Services\Contracts\BreweryService;

class BreweryController extends Controller
{
    public function __construct(private readonly BreweryService $breweryService) {}

    public function index(BreweryRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $result = $this->breweryService->getPaginatedBreweries($page, $perPage);

        return new JsonResponse([
            'data' => new Collection($result->items()),
            'pagination' => [
                'current_page' => $result->currentPage(),
                'per_page' => $result->perPage(),
                'total_pages' => $result->lastPage(),
                'total_results' => $result->total(),
                'has_more_pages' => $result->hasMorePages(),
            ],
        ], 200);
    }
}
