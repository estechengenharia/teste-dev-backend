<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Services\JobOfferService;
use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use Illuminate\Http\JsonResponse;

class JobOfferController extends Controller
{
    protected $jobOfferService;

    public function __construct(JobOfferService $jobOfferService)
    {
        $this->jobOfferService = $jobOfferService;
    }

    public function index(): JsonResponse
    {
        $jobOffers = $this->jobOfferService->getJobOffers(
            request()->all(),
            request('sort_by', 'id'),
            request('sort_direction', 'asc')
        );

        return response()->json([
            'success' => true,
            'data' => $jobOffers
        ]);
    }

    public function store(StoreJobOfferRequest $request): JsonResponse
    {
        $jobOffer = $this->jobOfferService->createJobOffer($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $jobOffer,
            'message' => 'Vaga criada com sucesso'
        ], 201);
    }

    public function show(JobOffer $jobOffer): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $jobOffer
        ]);
    }

    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer): JsonResponse
    {
        $updatedJobOffer = $this->jobOfferService->updateJobOffer($jobOffer, $request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $updatedJobOffer,
            'message' => 'Vaga atualizada com sucesso'
        ]);
    }

    public function destroy(JobOffer $jobOffer): JsonResponse
    {
        $this->jobOfferService->deleteJobOffer($jobOffer);
        
        return response()->json([
            'success' => true,
            'message' => 'Vaga removida com sucesso'
        ]);
    }

    public function toggleStatus(JobOffer $jobOffer): JsonResponse
    {
        $updatedJobOffer = $this->jobOfferService->toggleJobOfferStatus($jobOffer);
        
        return response()->json([
            'success' => true,
            'data' => $updatedJobOffer,
            'message' => 'Status da vaga atualizado'
        ]);
    }
}