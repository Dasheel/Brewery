<?php

namespace App\Http\Clients\Contracts;

interface OpenBreweryClient
{
    public function getMetaData(): int;

    public function getBreweries(int $page, int $perPage): array;
}
