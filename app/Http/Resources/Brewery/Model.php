<?php

namespace App\Http\Resources\Brewery;

use App\Dto\BreweryDto;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BreweryDto
 */
class Model extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brewery_type' => $this->breweryType,
            'address_1' => $this->address1,
            'address_2' => $this->address2,
            'address_3' => $this->address3,
            'city' => $this->city,
            'state_province' => $this->stateProvince,
            'postal_code' => $this->postalCode,
            'country' => $this->country,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'phone' => $this->phone,
            'website_url' => $this->websiteUrl,
            'state' => $this->state,
            'street' => $this->street,
        ];
    }
}
