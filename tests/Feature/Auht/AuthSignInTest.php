<?php

namespace Tests\Feature\Auht;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 */
class AuthSignInTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsATokenForValidCredentials(): void
    {
        User::factory()->create([
            'username' => 'root',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson(route('sign-in'), [
            'username' => 'root',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
        ]);
    }

    /**
     * @dataProvider invalidAuthProvider
     *
     * @param string $input
     * @param mixed  $value
     */
    public function testInvalidAuthRequest(string $input, mixed $value): void
    {
        $response = $this->postJson(route('sign-in'), [$input => $value]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor($input);
    }

    public function testReturnsUnauthorizedForInvalidCredentials()
    {
        User::factory()->create([
            'username' => 'root',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson(route('sign-in'), [
            'username' => 'root',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Unauthorized',
            'message' => 'Credenziali non valide',
        ]);
    }

    public static function invalidAuthProvider()
    {
        return [
            ['username', true],
            ['username', false],
            ['username', []],
            ['username', null],
            ['username', 999],
            ['password', true],
            ['password', false],
            ['password', null],
            ['password', 999],
            ['password', 'foo'],
        ];
    }
}
