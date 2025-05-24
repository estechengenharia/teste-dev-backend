<?php

namespace App\Http\Controllers;

use App\Models\{JobOffer,User,UserJobOfferApplication};
use App\Services\JobApplicationService;
use App\Http\Requests\StoreJobOfferApplicationRequest;
use Illuminate\Http\JsonResponse;

class JobOfferApplicationController extends Controller
{
    protected $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    public function index(): JsonResponse
    {
        $applications = $this->jobApplicationService->getApplications(
            request()->all(),
            request('sort_by', 'created_at'),
            request('sort_direction', 'desc')
        );

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }

    public function store(StoreJobOfferApplicationRequest $request): JsonResponse
    {
        try {
            $application = $this->jobApplicationService->createApplication($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $application,
                'message' => 'Candidatura realizada com sucesso'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show(UserJobOfferApplication $application): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    public function getUserApplications(User $user): JsonResponse
    {
        $applications = $user->jobApplications;
        
        return response()->json([
            'success' => true,
            'data' => $applications,
            'message' => 'Candidaturas do usuário obtidas com sucesso'
        ]);
    }

    public function getJobOfferApplicants(JobOffer $jobOffer): JsonResponse
    {
        $applicants = $jobOffer->applicants;
        
        return response()->json([
            'success' => true,
            'data' => $applicants,
            'message' => 'Candidatos da vaga obtidos com sucesso'
        ]);
    }

    public function destroy(User $user, JobOffer $jobOffer): JsonResponse
    {
       $this->jobApplicationService->deleteApplication($user, $jobOffer);

        return response()->json([
            'success' => true,
            'message' => 'Candidatura removida com sucesso'
        ]);
    }
}