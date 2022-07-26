<?php

namespace App\Services;

use App\Http\Resources\Candidate\CandidateResource;
use App\Repositories\Candidate\CandidateContract;
use App\Repositories\Job\JobContract;
use App\Traits\ApiResponse;

class CandidateService {
    private $candidate;
    private $job;
    use ApiResponse;

    public function __construct(CandidateContract $candidate, JobContract $job)
    {
        $this->candidate = $candidate;
        $this->job = $job;
    }

    /**
     * Candidate Lis
     *
     * @param int $perPage
     * @throws GeneralException
     * @return mixed
     */
    public function index($perPage = 20)
    {
        try{
            $candidates = $this->candidate->index($perPage);

            $paginateInfo = [
                'page_size' => $candidates->perPage(),
                'current_page' => $candidates->currentPage(),
                'total' => $candidates->total()
            ];

            return $this->success(CandidateResource::collection($candidates), null, 200, $paginateInfo);
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate show
     *
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function show($id)
    {
        try{
            $candidate = $this->candidate->show($id);
            if(!$candidate)
                return $this->error('Candidate not found!', 404);

            return $this->success(
                new CandidateResource($candidate)
            );
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate store
     *
     * @param array $imputs
     * @throws GeneralException
     * @return mixed
     */
    public function store(array $inputs)
    {
        try{
            $jobs = [];
            if(isset($inputs['jobs']) && count($inputs['jobs']) > 0){
                $jobs = $inputs['jobs'];
                unset($inputs['jobs']);
            }
            return $this->success(
                new CandidateResource($this->candidate->store($inputs, $jobs)),
                'Successful registered candidate!'
            );
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate update
     *
     * @param array $inputs
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function update(array $inputs, string $id)
    {
        try{
            if(!$candidate = $this->candidate->update($inputs, $id))
                return $this->error('Candidate not found!', 404);

            return $this->success(new CandidateResource($candidate), 'Successful updated us!');
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate delete
     *
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function destroy($id)
    {
        try{
            if(!$candidate = $this->candidate->destroy($id))
                return $this->error('Candidate not found!', 404);

            return $this->success(null, 'Candidate successfully deleted!');
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate filter
     *
     * @param int $perPage
     * @throws GeneralException
     * @return mixed
     */
    public function search($perPage = 20)
    {
        try{
            $parameter = [
                'name' => request()->query('name'),
                'email' => request()->query('email'),
                'type' => request()->query('type'),
                'status' => request()->query('status'),
                'created_at' => request()->query('created_at'),
            ];

            $candidate = $this->candidate->search($parameter, $perPage);
            if($candidate->count() < 1)
                return $this->error('Candidate not found!', 404);
                
            return $this->success(CandidateResource::collection($candidate));
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Candidate status update
     *
     * @param bool $status
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function statusUpdate(bool $statu, string $id)
    {
        try{
            $candidate = $this->candidate->find($id);
            if(!is_object($candidate))
                return $this->error('Candidate not found!', 404);

            return  $this->success(new CandidateResource($candidate));
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * User filter
     *
     * @param array $jobs
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function jobAttach(array $jobs, string $id)
    {
        try{
            $jobs = $this->job->whereIn($jobs)->pluck('id')->toArray();
            $candidate = $this->candidate->find($id);
            
            if(count($jobs)  < 1)
                return $this->error('Candidate not found!', 404);
            
            if(!is_object($candidate))
                return $this->error('Candidate not found!', 404);

            return  $this->success(new CandidateResource($this->candidate->jobAttach($jobs, $id)));
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }
}