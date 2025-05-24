<?php

namespace Tests\Feature\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserLoginErrorTest extends TestCase
{
    public function test_the_get_user_login_endpoint_error(): void
    {
        $authData = array();
        $response = $this->post('/api/login');

        $response->assertStatus(302);
    }
}
