<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Interface\CompanyInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyInterface
{
    public function all(int $perPage, int $page, $search): LengthAwarePaginator
    {
        $query = Company::with('category');

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($query) use ($search) {
                          $query->where('title', 'like', '%' . $search . '%');
                      });
            });
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }


    public function find(int $id): Company
    {
        return Company::findOrFail($id);
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function update(int $id, array $data): Company
    {
        $company = Company::find($id);

        if (!$company) {
            throw new \Exception('Company not found');
        }

        $company->update($data);

        return $company;
    }


    public function delete(int $id): bool
    {
        $company = $this->find($id);
        return $company->delete();
    }
}
