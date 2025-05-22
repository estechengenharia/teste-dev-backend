<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateUserErrorTest extends TestCase
{
    public function test_the_create_user_endpoint_error()
    {
        $userWithoutData = array();

        $response = $this->postJson('/api/users', $userWithoutData);

        $response->assertStatus(422);
    }
}
