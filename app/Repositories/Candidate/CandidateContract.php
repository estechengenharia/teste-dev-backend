<?php

namespace App\Repositories\Candidate;

interface CandidateContract
{
    public function index(int $per_page);
    public function show(string $id);
    public function store(array $inputs, array $jobs);
    public function update(array $inputs, string $id);
    public function destroy(string $id);
    public function search(array $parameter, int $perPage);
    public function find(string $id);
    public function statusUpdate(int $status, string $id);
    public function jobAttach(array $jobs, string $id);
}