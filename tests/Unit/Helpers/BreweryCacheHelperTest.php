<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Helpers\BreweryCacheHelper;
use Illuminate\Support\Facades\Cache;
use App\Http\Clients\Contracts\OpenBreweryClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryCacheHelperTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTotalReturnsCachedValue()
    {
        Cache::shouldReceive('remember')->once()->andReturn(100);

        /** @var BreweryCacheHelper $breweryCacheHelper */
        $breweryCacheHelper = $this->app->make(BreweryCacheHelper::class);
        $totalBreweries = $breweryCacheHelper->getTotal();

        $this->assertEquals(100, $totalBreweries);
    }

    public function testGetTotalCallsApiWhenCacheIsEmpty()
    {
        $this->mock(OpenBreweryClient::class, function (MockInterface $mock) {
            $mock->allows('getMetaData')->once()->andReturn(100);
        });

        /** @var BreweryCacheHelper $breweryCacheHelper */
        $breweryCacheHelper = $this->app->make(BreweryCacheHelper::class);
        $totalBreweries = $breweryCacheHelper->getTotal();

        $this->assertEquals(100, $totalBreweries);
    }
}
