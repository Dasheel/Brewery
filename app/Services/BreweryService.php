<?php

namespace App\Services;

use App\Collections\BreweryCollection;
use App\Helpers\Contracts\BreweryCacheHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Clients\Contracts\OpenBreweryClient;
use App\Services\Contracts\BreweryService as BreweryServiceContract;

class BreweryService implements BreweryServiceContract
{
    public function __construct(
        private readonly BreweryCacheHelper $breweryHelper,
        private readonly OpenBreweryClient $breweryClient
    ) {}

    public function getPaginatedBreweries(int $page, int $perPage): LengthAwarePaginator
    {
        $total = $this->breweryHelper->getTotal();

        if ($perPage == -1) {
            $perPage = $total;
            $page = 1;
        }

        $totalPages = (int) ceil($total / $perPage);

        if ($page > $totalPages || $page < 1) {
            throw new \Exception('La pagina richiesta non esiste.');
        }

        $items = $this->breweryClient->getBreweries($page, $perPage);

        $breweryCollection = BreweryCollection::newInstanceFrom($items);

        return new LengthAwarePaginator(
            $breweryCollection,
            $total,
            $perPage,
            $page,
        );
    }
}
