<?php

namespace App\Collections;

use App\Dto\BreweryDto;
use Illuminate\Support\Collection;

class BreweryCollection extends Collection
{
    public static function newInstanceFrom(array $data): self
    {
        $breweries = array_map(fn ($brewery) => BreweryDto::newInstanceFrom($brewery), $data);

        return new self($breweries);
    }
}
