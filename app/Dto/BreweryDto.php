<?php

namespace App\Dto;

class BreweryDto
{
    public function __construct(
        public string $id,
        public ?string $name,
        public ?string $breweryType,
        public ?string $address1,
        public ?string $address2,
        public ?string $address3,
        public ?string $city,
        public ?string $stateProvince,
        public ?string $postalCode,
        public ?string $country,
        public ?string $longitude,
        public ?string $latitude,
        public ?string $phone,
        public ?string $websiteUrl,
        public ?string $state,
        public ?string $street,
    ) {}

    public static function newInstanceFrom(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            $data['name'] ?? null,
            $data['brewery_type'] ?? null,
            $data['address_1'] ?? null,
            $data['address_2'] ?? null,
            $data['address_3'] ?? null,
            $data['city'] ?? null,
            $data['state_province'] ?? null,
            $data['postal_code'] ?? null,
            $data['country'] ?? null,
            $data['longitude'] ?? null,
            $data['latitude'] ?? null,
            $data['phone'] ?? null,
            $data['website_url'] ?? null,
            $data['state'] ?? null,
            $data['street'] ?? null
        );
    }
}
