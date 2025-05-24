<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\User;
use App\Models\UserJobOfferApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // recruiters
        User::factory()
            ->count(2)
            ->recruiter()
            ->create();

        // regular users
        User::factory()
            ->count(20)
            ->create();

        JobOffer::factory()
            ->count(15)
            ->create();

        UserJobOfferApplication::factory()
            ->count(30)
            ->create();
    }
}
