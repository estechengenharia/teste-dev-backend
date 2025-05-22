<?php

namespace Tests\Feature\JobOffer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\JobOffer;

class GetJobOfferSuccessTest extends TestCase
{
    public function test_the_get_job_offer_endpoint_success(): void
    {
        $jobOffer = JobOffer::firstOrFail();
        $response = $this->get("/api/job-offers/{$jobOffer->id}");

        $response->assertStatus(200);
    }
}
