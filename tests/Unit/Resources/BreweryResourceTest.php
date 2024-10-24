<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Dto\BreweryDto;
use App\Http\Resources\Brewery\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testBreweryResourceTransformsCorrectly(): void
    {
        $breweryDto = new BreweryDto(
            '1',
            'Test Brewery',
            'micro',
            '123 Main St',
            null,
            null,
            'Test City',
            'Test State',
            '12345',
            'Test Country',
            '-97.0',
            '35.0',
            '555-555-5555',
            'http://testbrewery.com',
            'Test State',
            '123 Main St'
        );

        $breweryResource = (new Model($breweryDto));

        $this->assertEquals([
            'id' => '1',
            'name' => 'Test Brewery',
            'brewery_type' => 'micro',
            'address_1' => '123 Main St',
            'address_2' => null,
            'address_3' => null,
            'city' => 'Test City',
            'state_province' => 'Test State',
            'postal_code' => '12345',
            'country' => 'Test Country',
            'longitude' => '-97.0',
            'latitude' => '35.0',
            'phone' => '555-555-5555',
            'website_url' => 'http://testbrewery.com',
            'state' => 'Test State',
            'street' => '123 Main St',
        ], $breweryResource->toArray(null));
    }
}
