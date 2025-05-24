<?php

namespace Tests\Feature\JobApplication;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GetUserApplicationsErrorTest extends TestCase
{
    public function test_the_get_job_offer_application_endpoint_error(): void
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

        $protectedResponse = $this->withToken($token)->get('/api/applications/user/0');

        $protectedResponse->assertStatus(404);
    }
}
