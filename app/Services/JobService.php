<?php
namespace App\Services;

use App\Http\Resources\Job\JobResource;
use App\Repositories\Job\JobContract;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class JobService {
    private $job;
    use ApiResponse;

    public function __construct(JobContract $job)
    {
        $this->job = $job;
    }

    /**
     * Job Lis
     *
     * @param int $perPage
     * @throws GeneralException
     * @return mixed
     */
    public function index($perPage)
    {
        try{
            $jobs = $this->job->index($perPage);
            $paginateInfo = [
                'page_size' => $jobs->perPage(),
                'current_page' => $jobs->currentPage(),
                'total' => $jobs->total()
            ];
            return $this->success(JobResource::collection($jobs), null, 200, $paginateInfo);
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job show
     *
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function show($id)
    {
        try{
            $job = $this->job->show($id);
            if(!is_object($job))
                return $this->error('Job not found!', 404);

            return $this->success(new JobResource($job));
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job store
     *
     * @param array $imputs
     * @throws GeneralException
     * @return mixed
     */
    public function store(array $inputs)
    {
        try{
            return $this->success(
                new JobResource($this->job->store($inputs)),
                'Successful registered job!'
            );
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job update
     *
     * @param array $inputs
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function update(array $inputs, $id)
    {
        try{
            if(!$job = $this->job->update($inputs, $id))
                return $this->error('Job not found!', 404);

            return $this->success(new JobResource($job), 'Successful updated us!');
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job delete
     *
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function destroy($id)
    {
        try{
            if(!$job = $this->job->destroy($id))
                return $this->error('Job not found!', 404);

            return $this->success(null, 'Job successfully deleted!');
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job filter
     *
     * @param int $perPage
     * @throws GeneralException
     * @return mixed
     */
    public function search($perPage)
    {
        try{
            $parameter = [
                'title' => request()->query('title'),
                'description' => request()->query('description'),
                'type' => request()->query('type'),
                'status' => request()->query('status'),
                'created_at' => request()->query('created_at'),
            ];

            $job = $this->job->search($parameter, $perPage);
            if($job->count() < 1)
                return $this->error('Job not found!', 404);

            $paginateInfo = [
                'page_size' => $job->perPage(),
                'current_page' => $job->currentPage(),
                'total' => $job->total()
            ];
                
            return $this->success(JobResource::collection($job), null, 200, $paginateInfo);
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Job status update
     *
     * @param boolean $status
     * @param string $id
     * @throws GeneralException
     * @return mixed
     */
    public function statusUpdate(bool $status, string $id)
    {
        try{
            if(!$job = $this->job->find($id))
            return $this->error('Job not found!', 404);

            return $this->success(new JobResource($this->job->statusUpdate($status, $id)));
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }


}