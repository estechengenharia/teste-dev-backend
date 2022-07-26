<?php

namespace App\Repositories\Candidate;

use App\Models\User;
use App\Repositories\User\UserContract;
use Illuminate\Support\Facades\Cache;

class CandidateRepository implements CandidateContract{
    private $candidate;

    public function __construct(User $candidate)
    {
        $this->candidate = $candidate;
    }
    
    public function index(int $perPage)
    {
        return Cache::remember('candidates', 120, function() use ($perPage){
            return $this->candidate->with('jobs')->where('type', 1)->paginate($perPage);
        });
    }
    public function show(string $id)
    {
        $candidate = $this->find($id);

        return $candidate;
    }
    public function store(array $inputs, array $jobs)
    {
        cacheClear(['candidates', 'candidate-search']);

        $candidate = $this->candidate->create($inputs);

        if(count($jobs) > 0)
            $candidate->jobs()->attach($jobs);

        return $candidate;
    }
    public function update(array $inputs, string $id)
    {
        cacheClear(['candidates', 'candidate-search']);

        $candidate = $this->find($id);
        if(!$candidate)
            return false;

        $candidate->update($inputs);

        return $candidate;
    }
    public function destroy(string $id)
    {
        cacheClear(['candidates', 'candidate-search']);

        $candidate = $this->candidate->find($id);
        if(is_object($candidate))
            return $candidate->delete();

        return false;
    }
    public function search(array $parameter, int $perPage)
    {
        

        return Cache::remember('candidate-search', 120, function() use($parameter, $perPage){
            return $this->candidate->when($parameter['name'], function($query, $name){
                return $query->where('type', 1)->where('name', 'LIKE', "%{$name}%");
            })->when($parameter['email'], function($query, $email){
                return $query->where('type', 1)->where('email', 'LIKE', "%{$email}%");
            })->when($parameter['type'], function($query, $type){
                return $query->where('type', 1)->where('type', $type );
            })->when($parameter['status'], function($query, $status){
                return $query->where('type', 1)->where('status', $status );
            })->when($parameter['created_at'], function($query, $created_at){
                return $query->where('type', 1)->where('created_at', $created_at );
            })->paginate($perPage);
        });
    }

    public function find($id)
    {
        return $this->candidate->with('jobs')->find($id);
    }

    public function statusUpdate(int $status, string $id)
    {
        cacheClear(['candidates', 'candidate-search']);

        $candidate = $this->find($id);

        $candidate->update(['status' => $status]);

        return $candidate;
    }

    public function jobAttach(array $jobs, string $id)
    {
        $candidate = $this->find($id);
        if(is_object($candidate))
            $candidate->jobs()->attach($jobs);

        return $candidate;
    }
}