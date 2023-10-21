<?php

namespace App\Services\Interfaces;


interface EmployeeDashboardServiceInterface
{
   public function all(int $company_id);
   public function allMinimum(int $company_id);
   public function paginate(int $company_id);
   public function select(int $company_id);
   public function archive(int $company_id);
   public function archivePaginate(int $company_id);
   public function create(array $data,int $company_id);
   public function show(int $id);
   public function showArchive(int $id);
   // public function update(array $data,int $id);
   public function getMinimum(int $id);
   public function destroy(int $id);
   public function forceDelete(int $id);
   public function restore(int $id);
   public function restoreAndUpdate(array $data,int $id);
   public function multiDelete(array $ids);
   public function multiForceDelete(array $ids);
   public function search(int $company_id, $from, $to, $department_id, $is_complete, $sort, $paginate = 1);
   public function searchArchive(int $company_id, $from, $to, $sort, $paginate = 1);
   public function export(array $columns, string $extension, array $ids = null,array $filter = null);

   public function createOrUpdate(array $data,int $company_id, int $employee_id = null);


}
