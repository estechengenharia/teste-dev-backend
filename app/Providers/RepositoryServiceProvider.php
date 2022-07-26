<?php

namespace App\Providers;

use App\Repositories\Candidate\CandidateContract;
use App\Repositories\Candidate\CandidateRepository;
use App\Repositories\Job\JobContract;
use App\Repositories\Job\JobRepository;
use App\Repositories\User\UserContract;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserContract::class,
            UserRepository::class
        );
        $this->app->bind(
            JobContract::class,
            JobRepository::class
        );
        $this->app->bind(
            CandidateContract::class,
            CandidateRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
