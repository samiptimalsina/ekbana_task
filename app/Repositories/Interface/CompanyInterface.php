<?php

namespace App\Repositories\Interface;
use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyInterface
{
    public function all(int $perPage, int $page,$search): LengthAwarePaginator;
    public function find(int $id): Company;
    public function create(array $data): Company;
    public function update(int $id, array $data): Company;
    public function delete(int $id): bool;
}



?>
