<?php

namespace App\Services;

use App\Models\{JobOffer,User,UserJobOfferApplication};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class JobApplicationService
{
    public function getApplications(array $filters = [], string $sortBy = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        $query = UserJobOfferApplication::query();

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['job_offer_id'])) {
            $query->where('job_offer_id', $filters['job_offer_id']);
        }

        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate(20);
    }

    public function createApplication(array $data): UserJobOfferApplication
    {
        $jobOffer = JobOffer::findOrFail($data['job_offer_id']);

        if (!$jobOffer->active) {
            throw new \Exception('Esta vaga está pausada e não aceita novas candidaturas');
        }

        return UserJobOfferApplication::create($data);
    }

    public function deleteApplication(User $user, JobOffer $jobOffer): void
    {
        DB::table('user_job_offer_applications')
            ->where('user_id', $user->id)
            ->where('job_offer_id', $jobOffer->id)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now()
            ]);
    }
}