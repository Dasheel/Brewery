<?php

namespace App\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface BreweryService
{
    public function getPaginatedBreweries(int $page, int $perPage): LengthAwarePaginator;
}
