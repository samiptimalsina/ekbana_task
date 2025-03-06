<?php

namespace App\Repositories\Interface;
use App\Models\CompanyCategory;
use Illuminate\Pagination\LengthAwarePaginator;
interface CompanyCategoryInterface
{
    public function all(int $perPage, int $page, $search): LengthAwarePaginator;
    public function find(int $id): CompanyCategory;
    public function create(array $data): CompanyCategory;
    public function update(int $id, array $data): CompanyCategory;
    public function delete(int $id): bool;
    public function search(string $search);

}




