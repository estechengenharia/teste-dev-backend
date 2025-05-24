<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UpdateUserErrorTest extends TestCase
{
    public function test_the_update_user_endpoint_error(): void
    {
        $user = User::firstOrFail();
        $response = $this->put("/api/users/{$user->id}", ['name' => '']);

        $response->assertStatus(302);
    }
}
