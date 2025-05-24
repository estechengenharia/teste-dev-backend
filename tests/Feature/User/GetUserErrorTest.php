<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GetUserErrorTest extends TestCase
{
    public function test_the_get_user_endpoint_error(): void
    {
        $response = $this->get('/api/users/0');

        $response->assertStatus(404);
    }
}
