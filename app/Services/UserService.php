<?php

namespace App\Services;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserContract;
use App\Traits\ApiResponse;

class UserService {
    
    private $user;
    use ApiResponse;

    public function __construct(UserContract $user)
    {
        $this->user = $user;
    }

    /**
     * Undocumented function
     *
     * @param integer $perPage
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function index(int $perPage)
    {
        try{
            $users = $this->user->index($perPage);
            $paginateInfo = [
                'page_size' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'total' => $users->total()
            ];
            return $this->success(UserResource::collection($users), null, 200, $paginateInfo);
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Show user
     *
     * @param string $id
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try{
            $user = $this->user->show($id);
            if(!$user)
                return $this->error('User not found!', 404);

            return $this->success(new UserResource($user));
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * User create 
     *
     * @param StoreUserRequest $request
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function store(array $inputs)
    {
        $inputs['password'] = bcrypt($inputs['password']);

        return $this->success(
            new UserResource($this->user->store($inputs)),
            'Successful registered user!'
        );
    }

    /**
     * User update
     *
     * @param array $inputs
     * @param string $id
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function update(array $inputs, string $id)
    {
        try{
            if(!$user = $this->user->update($inputs, $id))
                return $this->error('User not found!', 404);

            return $this->success(new UserResource($user), 'Successful updated us!');
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * User delete
     *
     * @param string $id
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try{
            if(!$user = $this->user->destroy($id))
                return $this->error('User not found!', 404);

            return $this->success(null, 'User successfully deleted!');
        }catch(\Exception $exception){
            $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * User filter
     *
     * @param array $parameter
     * @param int $perPage
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function search($parameter, int $perPage)
    {
        $user = $this->user->search($parameter, $perPage);
        if($user->count() < 1)
            return $this->error('User not found!', 404);

        $paginateInfo = [
            'page_size' => $user->perPage(),
            'current_page' => $user->currentPage(),
            'total' => $user->total()
        ];
            
        return $this->success(UserResource::collection($user), null, 200, $paginateInfo);
    }
}