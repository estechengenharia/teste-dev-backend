<?php

namespace App\Http\Resources\Candidate;

use App\Http\Resources\Job\JobResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => config('utils.job_types')[$this->type],
            'status' => $this->status,
            'jobs' => JobResource::collection($this->jobs),
        ];
    }
}
