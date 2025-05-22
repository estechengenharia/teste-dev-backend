<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\JobOffer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserJobOfferApplication>
 */
class UserJobOfferApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'job_offer_id' => JobOffer::factory(),
        ];
    }
}
