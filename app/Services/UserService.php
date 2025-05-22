<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected $cacheTtl = 60;

    public function getUsers(array $filters = [], string $sortBy = 'id', string $sortDirection = 'asc'): LengthAwarePaginator
    {
        $cacheKey = $this->generateCacheKey($filters, $sortBy, $sortDirection);

        return Cache::tags(['users'])->remember($cacheKey, $this->cacheTtl, function () use ($filters, $sortBy, $sortDirection) {
            $query = User::query();

            if (isset($filters['name'])) {
                $query->where('name', 'like', '%'.$filters['name'].'%');
            }

            if (isset($filters['email'])) {
                $query->where('email', 'like', '%'.$filters['email'].'%');
            }

            if (isset($filters['is_recruiter'])) {
                $query->where('is_recruiter', $filters['is_recruiter']);
            }

            $query->orderBy($sortBy, $sortDirection);

            return $query->paginate(20);
        });
    }

    protected function generateCacheKey(array $filters, string $sortBy, string $sortDirection): string
    {
        return 'users_'.md5(json_encode([
            'filters' => $filters,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'page' => request()->input('page', 1)
        ]));
    }

    public function clearUsersCache(): void
    {
        Cache::tags(['users'])->flush();
    }

    public function createUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function deleteUsers(array $userIds): void
    {
        User::whereIn('id', $userIds)->delete();
        $this->clearUsersCache();
    }
}