<?php

namespace App\Repositories\Job;

interface JobContract {
    public function index(int $perPage);
    public function show(string $id);
    public function store(array $inputs);
    public function update(array $inputs, string $id);
    public function destroy(string $id);
    public function search(array $parameter, int $perPage);
    public function find(string $id);
    public function statusUpdate(bool $status, string $id);
    public function whereIn(array $jobs);
}