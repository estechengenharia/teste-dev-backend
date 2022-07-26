<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserContract;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;
    use ApiResponse;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    /**
     * Get user list
     *
     * @param integer $perPage
     * @return \Illuminate\Http\Response
     */
    public function index($perPage = 20)
    {
        return $this->user->index($perPage);
    }

    /**
     * Show user
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->user->show($id);
    }

    /**
     * User create 
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        return $this->user->store($request->all());
    }

    /**
     * User update
     *
     * @param UpdateUserRequest $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        return $this->user->update($request->all(), $id);
    }

    /**
     * User delete
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->user->destroy($id);
    }

    /**
     * User filter
     *
     * @param Request $request
     * @param integer $perPage
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $perPage = 20)
    {
        return $this->user->search($request->parameter, $perPage);
    }
}
