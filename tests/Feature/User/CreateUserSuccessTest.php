<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateUserSuccessTest extends TestCase
{
    public function test_the_create_user_endpoint_success()
    {
        $userData = User::factory()->make()->toArray();

        $userData['password'] = 'password123'; 

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }
}
