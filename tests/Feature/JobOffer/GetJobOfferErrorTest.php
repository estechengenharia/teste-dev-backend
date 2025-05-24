<?php

namespace Tests\Feature\JobOffer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\JobOffer;

class GetJobOfferErrorTest extends TestCase
{
    public function test_the_get_job_offer_endpoint_error(): void
    {
        $response = $this->get('/api/job-offers/0');

        $response->assertStatus(404);
    }
}
