<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Http\Clients\Contracts\OpenBreweryClient;
use App\Helpers\Contracts\BreweryCacheHelper as BreweryHelperContract;

class BreweryCacheHelper implements BreweryHelperContract
{
    public function __construct(private readonly OpenBreweryClient $breweryClient) {}

    public function getTotal(): int
    {
        return Cache::remember('total_breweries', now()->addDay(), fn () => $this->breweryClient->getMetaData());
    }
}
