<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\BreweryService;
use App\Helpers\Contracts\BreweryCacheHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Clients\Contracts\OpenBreweryClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetPaginatedBreweriesReturnsPaginator(): void
    {
        $this->mock(BreweryCacheHelper::class, function (MockInterface $mock) {
            $mock->allows('getTotal')->once()->andReturn(100);
        });

        $this->mock(OpenBreweryClient::class, function (MockInterface $mock) {
            $mock->allows('getBreweries')->once()->with(1, 10)->andReturn([
                ['id' => '1', 'name' => 'foo', 'brewery_type' => 'bar', 'city' => 'baz'],
                ['id' => '2', 'name' => 'foo2', 'brewery_type' => 'bar2', 'city' => 'baz2'],
            ]);
        });

        /** @var BreweryService $breweryCacheHelper */
        $service = $this->app->make(BreweryService::class);
        $result = $service->getPaginatedBreweries(1, 10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(100, $result->total());
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals('foo', $result->items()[0]->name);
        $this->assertEquals('baz', $result->items()[0]->city);
    }

    public function testThrowsExceptionForInvalidPage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('La pagina richiesta non esiste.');

        $this->mock(BreweryCacheHelper::class, function (MockInterface $mock) {
            $mock->allows('getTotal')->once()->andReturn(100);
        });

        $this->mock(OpenBreweryClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('getBreweries')->never();
        });

        /** @var BreweryService $breweryCacheHelper */
        $service = $this->app->make(BreweryService::class);
        $service->getPaginatedBreweries(11, 10);
    }
}
