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
        $response->assertStatus(401);
    }

    /**
     * @dataProvider invalidBreweryProvider
     *
     * @param string $input
     * @param mixed  $value
     */
    public function testInvalidBreweryRequest(string $input, mixed $value): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->getJson(route('breweries-list', [$input => $value]));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor($input);
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

    public static function invalidBreweryProvider()
    {
        return [
            ['page', false],
            ['page', 'foo'],
            ['page', 0],
            ['page', ['foo']],
            ['per_page', 'foo'],
            ['per_page', 51],
            ['per_page', ['foo']],
        ];
    }
}
