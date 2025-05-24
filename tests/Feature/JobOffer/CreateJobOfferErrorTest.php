<?php

namespace Tests\Feature\JobOffer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\JobOffer;

class CreateJobOfferErrorTest extends TestCase
{
    public function test_the_create_job_offer_endpoint_error()
    {
        $jobOfferWithoutData = array();

        $response = $this->postJson('/api/job-offers', $jobOfferWithoutData);

        $response->assertStatus(401);
    }
}
