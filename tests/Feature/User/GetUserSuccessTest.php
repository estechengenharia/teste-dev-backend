<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GetUserSuccessTest extends TestCase
{
    public function test_the_get_user_endpoint_success(): void
    {
        $user = User::firstOrFail();
        $response = $this->get("/api/users/{$user->id}");

        $response->assertStatus(200);
    }
}
