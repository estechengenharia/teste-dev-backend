<?php

namespace App\Repositories\User;

interface UserContract
{
    public function index(int $per_page);
    public function show(string $id);
    public function store(array $inputs);
    public function update(array $inputs, string $id);
    public function destroy(string $id);
    public function search($parameter, int $perPage);
    public function find(string $id);
    public function statusUpdate(int $status, string $id);
}