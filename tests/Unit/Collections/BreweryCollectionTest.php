<?php

namespace Tests\Unit\Collections;

use App\Dto\BreweryDto;
use PHPUnit\Framework\TestCase;
use App\Collections\BreweryCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function testNewInstanceFrom(): void
    {
        $data = [
            [
                'id' => '1',
                'name' => 'name_1',
                'brewery_type' => 'type_1',
                'city' => 'city_1',
                'state_province' => 'state_1',
            ],
            [
                'id' => '2',
                'name' => 'name_2',
                'brewery_type' => 'type_2',
                'city' => 'city_2',
                'state_province' => 'state_2',
            ],
        ];

        $collection = BreweryCollection::newInstanceFrom($data);

        $this->assertCount(2, $collection);
        $this->assertInstanceOf(BreweryDto::class, $collection->first());

        $dto = $collection->first();
        $this->assertEquals('1', $dto->id);
        $this->assertEquals('name_1', $dto->name);
        $this->assertEquals('type_1', $dto->breweryType);
        $this->assertEquals('city_1', $dto->city);
        $this->assertEquals('state_1', $dto->stateProvince);
    }
}
