<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test error login with invalid credentials, wait status 401..
     *
     * @return void
     */
    public function test_error_login_invalid_credentials()
    {
        $credentials = [
            'email' => fake()->safeEmail(),
            'password' => '13345678'
        ];
        $response = $this->postJson("/api/v1/auth/login", $credentials);

        $response->assertStatus(401)
                    ->assertJson([
                        'status' => 'error',
                        'message' => 'Credentials do not match!',
                    ]);
    }

    /**
     * Test error login with password min size, wait status 422..
     *
     * @return void
     */
    public function test_error_login_password_min_size()
    {
        $credentials = [
            'email' => fake()->safeEmail(),
            'password' => '133'
        ];
        $response = $this->postJson("/api/v1/auth/login", $credentials);

        $response->assertStatus(422)
                    ->assertJson([
                        "message" => "The password must be at least 6 characters.",
                    ]);
    }

    /**
     * Test error login with min size, wait status 422..
     *
     * @return void
     */
    public function test_error_login_password_required()
    {
        $credentials = [
            'email' => fake()->safeEmail(),
            'password'
        ];
        $response = $this->postJson("/api/v1/auth/login", $credentials);

        $response->assertStatus(422)
                    ->assertJson([
                        "message" => "The password field is required.",
                    ]);
    }

    /**
     * Test success login , wait status 200..
     *
     * @return void
     */
    public function test_success_login()
    {
        $user = User::factory()->create(['type' => 1]);
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->postJson("/api/v1/auth/login", $credentials);

        $response->assertStatus(200)
                    ->assertJson([
                        "status" => "success",
                        "message" => "Successful login!",
                    ]);
    }

    /**
     * Test error logout unauthenticated, wait status 200..
     *
     * @return void
     */
    public function test_success_login_unauthenticated()
    {
        $response = $this->postJson("/api/v1/auth/logout");

        $response->assertStatus(401)
                    ->assertJson([
                        "message" => "Unauthenticated.",
                    ]);
    }

    /**
     * Test success logout , wait status 200..
     *
     * @return void
     */
    public function test_success_logout()
    {
        $user = User::factory()->create(['type' => 1]);
        $token = $user->createToken('API Token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->postJson("/api/v1/auth/logout");

        $response->assertStatus(200)
                    ->assertJson([
                        "status" => "success"
                    ]);
    }
}
