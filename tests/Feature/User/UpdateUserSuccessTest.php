<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UpdateUserSuccessTest extends TestCase
{
    public function test_the_update_user_endpoint_success(): void
    {
        $user = User::firstOrFail();
        $response = $this->put("/api/users/{$user->id}", ['name' => fake()->name()]);

        $response->assertStatus(200);
    }
}
