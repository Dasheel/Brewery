<?php

namespace Tests\Feature\Brewery;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class BreweryIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedUserCannotAccessBreweries(): void
    {
        $response = $this->getJson(route('breweries-list', ['page' => 1, 'perPage' => 10]));
        $response = $this->getJson('/api/breweries-list?page=1&per_page=10');
        $response->assertStatus(401);
    }

    public function testAuthenticatedUserCanAccessBreweries(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Http::fake([
            'https://api.openbrewerydb.org/breweries?page=1&per_page=10' => Http::response([
                ['id' => 1, 'name' => 'Test Brewery 1'],
            ], 200),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson(route('breweries-list', ['page' => 1, 'perPage' => 10]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                ],
            ],
            'pagination' => [
                'current_page',
                'per_page',
                'total_pages',
                'total_results',
                'has_more_pages',
            ],
        ]);
    }
}
