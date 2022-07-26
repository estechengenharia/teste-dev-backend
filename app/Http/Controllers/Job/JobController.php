<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\JobService;

class JobController extends Controller
{
    private $job;
    use ApiResponse;

    public function __construct(JobService $job)
    {
        $this->job = $job;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($perPage = 20)
    {
        return $this->job->index($perPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        return $this->job->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->job->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->job->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->job->destroy($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($perPage = 20)
    {
        return $this->job->search($perPage);
    }

    /**
     * Job status update
     *
     * @param boolean $status
     * @param string $id
     * @return mixed
     */
    public function statusUpdate($status, $id)
    {
        return $this->job->statusUpdate($status, $id);
    }
}
