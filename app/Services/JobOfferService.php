<?php

namespace App\Services;

use App\Models\JobOffer;
use Illuminate\Pagination\LengthAwarePaginator;

class JobOfferService
{
    public function getJobOffers(array $filters = [], string $sortBy = 'id', string $sortDirection = 'asc'): LengthAwarePaginator
    {
        $query = JobOffer::query();

        // Filtros
        if (isset($filters['title'])) {
            $query->where('title', 'like', '%'.$filters['title'].'%');
        }

        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }

        if (isset($filters['CLT'])) {
            $query->where('CLT', $filters['CLT']);
        }

        // Ordenação
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate(20);
    }

    public function createJobOffer(array $data): JobOffer
    {
        return JobOffer::create($data);
    }

    public function updateJobOffer(JobOffer $jobOffer, array $data): JobOffer
    {
        $jobOffer->update($data);
        return $jobOffer;
    }

    public function toggleJobOfferStatus(JobOffer $jobOffer): JobOffer
    {
        $jobOffer->update(['active' => !$jobOffer->active]);
        return $jobOffer;
    }

    public function deleteJobOffer(JobOffer $jobOffer): void
    {
        $jobOffer->delete();
    }
}