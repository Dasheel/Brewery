<?php

namespace Tests\Unit\Clients;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Http\Clients\OpenBreweryClient;
use Illuminate\Http\Client\RequestException;

/**
 * @internal
 */
class OpenBreweryClientTest extends TestCase
{
    public function testGetMetaDataReturnsTotalBreweries()
    {
        Http::fake([
            'https://api.openbrewerydb.org/v1/breweries/meta' => Http::response([
                'total' => 150,
            ], 200),
        ]);

        /** @var OpenBreweryClient $client */
        $client = $this->app->make(OpenBreweryClient::class);
        $totalBreweries = $client->getMetaData();

        $this->assertEquals(150, $totalBreweries);
    }

    public function testGetMetaDataThrowsExceptionOnFailure()
    {
        Http::fake([
            'https://api.openbrewerydb.org/v1/breweries/meta' => Http::response(null, 500),
        ]);

        $this->expectException(RequestException::class);

        /** @var OpenBreweryClient $client */
        $client = $this->app->make(OpenBreweryClient::class);
        $client->getMetaData();
    }

    public function testGetBreweriesReturnsBreweriesList()
    {
        Http::fake([
            'https://api.openbrewerydb.org/breweries?page=1&per_page=10' => Http::response([
                [
                    'id' => '1',
                    'name' => 'Brewery 1',
                    'brewery_type' => 'micro',
                    'city' => 'City 1',
                ],
                [
                    'id' => '2',
                    'name' => 'Brewery 2',
                    'brewery_type' => 'nano',
                    'city' => 'City 2',
                ],
            ], 200),
        ]);

        /** @var OpenBreweryClient $client */
        $client = $this->app->make(OpenBreweryClient::class);
        $breweries = $client->getBreweries(1, 10);

        $this->assertCount(2, $breweries);
        $this->assertEquals('Brewery 1', $breweries[0]['name']);
        $this->assertEquals('Brewery 2', $breweries[1]['name']);
    }

    public function testGetBreweriesThrowsExceptionOnFailure()
    {
        Http::fake([
            'https://api.openbrewerydb.org/breweries?page=1&per_page=10' => Http::response(null, 500),
        ]);

        $this->expectException(RequestException::class);

        /** @var OpenBreweryClient $client */
        $client = $this->app->make(OpenBreweryClient::class);
        $client->getBreweries(1, 10);
    }
}
