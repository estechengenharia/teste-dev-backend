<?php

namespace App\Repositories\Job;

use App\Models\Job;
use App\Repositories\User\UserContract;
use Illuminate\Support\Facades\Cache;

class JobRepository implements JobContract
{

    private $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**     
    * @param  $id
    * @param  int               $per_page
    * @return collection
    */
    
    public function index(int $perPage)
    {
        return Cache::remember('jobs', 120, function() use ($perPage){
            return $this->job->paginate($perPage);
        });
    }

    public function show($id)
    {
        $job = $this->find($id);

        return $job;
    }

    public function store(array $inputs)
    {
        cacheClear(['jobs', 'job-search', 'job-where-in']);
        $job = $this->job->create($inputs);
        return $job;
    }

    public function update($inputs, $id)
    {
        cacheClear(['jobs', 'job-search', 'job-where-in']);

        $job = $this->find($id);
        if(!$job)
            return false;

        $job->update($inputs);

        return $job;
    }

    public function destroy($id)
    {
        cacheClear(['jobs', 'job-search', 'job-where-in']);
        $job = $this->job->find($id);
        if(is_object($job))
            return $job->delete();

        return false;
    }

    public function search(array $parameter, int $perPage)
    {
        return Cache::remember('job-search', 120, function() use($parameter, $perPage){
            return $this->job->when($parameter['title'], function($query, $status){
                return $query->where('title', 'LIKE', "%{$status}%");
            })->when($parameter['description'], function($query, $description){
                return $query->where('description', 'LIKE', "%{$description}%");
            })->when($parameter['type'], function($query, $type){
                return $query->where('type', $type );
            })->when($parameter['created_at'], function($query, $created_at){
                return $query->where('created_at', $created_at );
            })->paginate($perPage);
        });
    }

    public function find(string $id)
    {
        return $this->job->find($id);
    }

    public function statusUpdate(bool $status, string $id)
    {
        cacheClear(['jobs', 'job-search', 'job-where-in']);

        $job = $this->find($id);

        $job->update(['status' => $status]);

        return $job;
    }

    public function whereIn(array $jobs)
    {
        return Cache::remember('job-where-in', 120, function() use ($jobs){
            return $this->job->whereIn('id', $jobs)->get();
        });
    }
}
