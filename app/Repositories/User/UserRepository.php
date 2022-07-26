<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserContract;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserContract
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**     
    * @param  $id
    * @param  int               $per_page
    * @return collection
    */
    
    public function index(int $perPage)
    {
        return Cache::remember('users', 120, function() use ($perPage){
            return $this->user->paginate($perPage);
        });
    }

    public function show($id)
    {
        $user = $this->find($id);

        return $user;
    }

    public function store(array $inputs)
    {
        cacheClear(['users']);
        $user = $this->user->create($inputs);
        return $user;
    }

    public function update($inputs, $id)
    {
        cacheClear(['users']);
        $user = $this->find($id);
        if(!$user)
            return false;

        $user->update($inputs);

        return $user;
    }

    public function destroy($id)
    {
        cacheClear(['users']);
        $user = $this->user->find($id);
        if(is_object($user))
            return $user->delete();

        return false;
    }

    public function search($parameter, int $perPage)
    {
        $results = $this->user->where('name', 'LIKE', "%{$parameter}%")
                        ->orWhere('email', 'LIKE', "%{$parameter}%")
                        ->orWhere('type', '=', $parameter)
                        ->orWhere('status', '=', $parameter)
                        ->orWhere('created_at', '=', $parameter)
                        ->paginate($perPage);
        return $results;
    }

    public function find(string $id)
    {
        return $this->user->find($id);
    }

    public function statusUpdate(int $status, string $id)
    {
        cacheClear(['users']);
        $user = $this->find($id);

        $user->update(['status' => $status]);

        return $user;
    }
}
