<?php

namespace App\Http\Resources\Brewery;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public $collects = Model::class;
}
