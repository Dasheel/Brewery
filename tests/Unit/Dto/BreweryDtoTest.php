<?php

namespace Tests\Unit\Dto;

use App\Dto\BreweryDto;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryDtoTest extends TestCase
{
    use RefreshDatabase;

    public function testNewInstanceFrom(): void
    {
        $data = [
            'id' => '1',
            'name' => 'name',
            'brewery_type' => 'type',
            'address_1' => 'address_1',
            'city' => 'city',
            'state_province' => 'state',
            'postal_code' => '12345',
            'country' => 'country',
            'phone' => '1234567890',
            'website_url' => 'http://www.testbrewery.com',
        ];

        $dto = BreweryDto::newInstanceFrom($data);

        $this->assertInstanceOf(BreweryDto::class, $dto);
        $this->assertEquals('1', $dto->id);
        $this->assertEquals('name', $dto->name);
        $this->assertEquals('type', $dto->breweryType);
        $this->assertEquals('address_1', $dto->address1);
        $this->assertEquals('city', $dto->city);
        $this->assertEquals('state', $dto->stateProvince);
        $this->assertEquals('12345', $dto->postalCode);
        $this->assertEquals('country', $dto->country);
        $this->assertEquals('1234567890', $dto->phone);
        $this->assertEquals('http://www.testbrewery.com', $dto->websiteUrl);
    }
}
