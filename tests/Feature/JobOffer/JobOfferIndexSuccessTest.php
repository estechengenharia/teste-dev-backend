<?php

namespace Tests\Feature\JobOffer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\JobOffer;

class JobOfferIndexSuccessTest extends TestCase
{
    public function test_the_job_offer_index_endpoint_success(): void
    {
        $response = $this->get('/api/job-offers');

        $response->assertStatus(200);
    }
}
