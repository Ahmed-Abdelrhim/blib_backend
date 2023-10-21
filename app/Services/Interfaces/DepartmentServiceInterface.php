<?php

namespace App\Services\Interfaces;

interface DepartmentServiceInterface
{
    public function all(int $company_id);
    public function select(int $company_id);
    public function allWithDetails(int $company_id);
    public function paginate(int $company_id);
    public function paginateWithDetails(int $company_id);
    public function create(array $data);
    public function show(int $id);
    public function getMinimum(int $id);
    public function update(array $data, int $id);
    public function destroy(int $id);
    public function multiDelete(array $ids);
    public function search(int $company_id,$from, $to, $sort, $paginate);
    public function export(array $columns, string $extension, array $ids = null, array $filter = null);
}
