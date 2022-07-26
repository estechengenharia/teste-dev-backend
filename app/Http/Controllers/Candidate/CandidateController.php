<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\JobAttatchCandidateRequest;
use App\Http\Requests\Candidate\StoreCandidateRequest;
use App\Http\Requests\Candidate\UpdateCandidateRequest;
use App\Services\CandidateService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    private $candidate;

    public function __construct(CandidateService $candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * List candidates resource in storage.
     *
     * @param  int  $perPage
     * @return \Illuminate\Http\Response
     */
    public function index($perPage = 20)
    {
        return $this->candidate->index($perPage);
    }

    /**
     * Show candidate resource in storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->candidate->show($id);
    }

    /**
     * Store candidate resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidateRequest $request)
    {
        return $this->candidate->store($request->all());
    }

    /**
     * Update candidate specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidateRequest $request, $id)
    {
        return $this->candidate->update($request->all(), $id);
    }

    /**
     * Delete candidate resource in storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->candidate->destroy($id);
    }

    /**
     * Search candidate resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($perPage = 20)
    {
        return $this->candidate->search($perPage);
    }

    /**
     * Update status the specified resource in storage.
     *
     * @param  bool $status
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate($statu, $id)
    {
        return $this->candidate->statusUpdate($statu, $id);
    }

    /**
     * links jobs the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jobAttach(JobAttatchCandidateRequest $request, $id)
    {
        return $this->candidate->jobAttach($request->all(), $id);
    }
}
