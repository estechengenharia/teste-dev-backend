<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getUsers(
            request()->all(),
            request('sort_by', 'id'),
            request('sort_direction', 'asc')
        );

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        $this->userService->clearUsersCache();

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Usuário criado com sucesso'
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userService->updateUser($user, $request->validated());
        $this->userService->clearUsersCache();

        return response()->json([
            'success' => true,
            'data' => $updatedUser,
            'message' => 'Usuário atualizado com sucesso'
        ]);
    }

    public function destroy(DestroyUserRequest $users): JsonResponse
    {
        $this->userService->deleteUsers($users->input('user_ids'));
        $this->userService->clearUsersCache();
        
        return response()->json([
            'success' => true,
            'message' => 'Usuário(s) removido(s) com sucesso'
        ]);
    }
}