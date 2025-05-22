<?php

namespace Tests\Feature\JobOffer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{JobOffer,User};

class DeleteJobOfferErrorTest extends TestCase
{
    public function test_the_delete_job_offer_endpoint_success(): void
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

        $protectedResponse = $this->withToken($token)->delete('/api/job-offers/0');

        $protectedResponse->assertStatus(404);
    }
}
