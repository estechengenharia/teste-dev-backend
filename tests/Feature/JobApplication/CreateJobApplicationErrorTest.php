<?php

namespace Tests\Feature\JobApplication;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{JobOffer,User};

class CreateJobApplicationErrorTest extends TestCase
{
    public function test_the_create_job_offer_application_endpoint_error()
    {
        $userData = User::factory()->recruiter()->make()->toArray();

        $userData['password'] = 'password123'; 

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);

        $userId = $response->json('data.id');
        
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

        $jobOfferData = JobOffer::factory()->make()->toArray();
        $jobOfferData['active'] = false;

        $protectedResponse = $this->withToken($token)->postJson('/api/job-offers', $jobOfferData);

        $protectedResponse->assertStatus(201);
        $jobOfferId = $protectedResponse->json('data.id');
        
        $this->assertDatabaseHas('job_offers', ['id' => $jobOfferId]);
        
        $protectedApplicationResponse = $this->withToken($token)->postJson('/api/applications', [
            'user_id' => $userId,
            'job_offer_id' => $jobOfferId
        ]);

        $protectedApplicationResponse->assertStatus(400);
    }
}
