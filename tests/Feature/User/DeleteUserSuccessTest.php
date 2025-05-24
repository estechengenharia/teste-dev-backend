<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DeleteUserSuccessTest extends TestCase
{
    public function test_the_delete_user_endpoint_success(): void
    {
        $user = User::latest()->firstOrFail();
        $response = $this->delete('/api/users', ['user_ids' => [$user->id]]);

        $response->assertStatus(200);
    }
}
