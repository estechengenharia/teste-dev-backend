<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserIndexSuccessTest extends TestCase
{
    public function test_the_user_index_endpoint_success(): void
    {
        $userData = User::factory()->recruiter()->make()->toArray();

        $userData['password'] = 'password123'; 

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);

        unset($userData->name, $userData->email_verified_at, $userData->recruiter);

        $loginResponse = $this->post('/api/login', $userData);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure([
                 'data' => [
                     'token',
                 ],
             ]);

        $token = $loginResponse->json('data.token');

        $protectedResponse = $this->withToken($token)->getJson('/api/users');

        $protectedResponse->assertStatus(200);
    }
}
