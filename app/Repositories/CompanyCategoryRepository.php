<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\CompanyCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interface\CompanyCategoryInterface;

class CompanyCategoryRepository implements CompanyCategoryInterface
{
    public function all(int $perPage, int $page,$search): LengthAwarePaginator
    {
        return CompanyCategory::paginate($perPage, ['*'], 'page', $page);
    }
    public function find(int $id): CompanyCategory
    {
        return CompanyCategory::findOrFail($id);
    }

    public function create(array $data): CompanyCategory
    {
        return CompanyCategory::create($data);
    }

    public function update(int $id, array $data): CompanyCategory
    {
        $companyCategory = $this->find($id);
        $companyCategory->update($data);

        return $companyCategory;
    }

    public function delete(int $id): bool
    {
        $companyCategory = $this->find($id);
        return $companyCategory->delete();
    }
    public function search(string $search)
    {
        $query = CompanyCategory::query();

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return $query->get();
    }
}
