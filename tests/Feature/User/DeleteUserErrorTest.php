<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DeleteUserErrorTest extends TestCase
{
    public function test_the_delete_user_endpoint_success(): void
    {
        $response = $this->delete('/api/users', [0]);

        $response->assertStatus(302);
    }
}
