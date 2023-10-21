<?php
namespace App\Repositories\Interfaces;


interface DepartmentRepositoryInterface
{
   public function all(int $company_id);
   public function paginate(int $company_id);
   public function create(array $data);
   public function firstOrCreate(array $data);
   public function allWithDetails(int $company_id);
   public function paginateWithDetails(int $company_id);
   public function show(int $id);
   public function showWithDetails(int $id);
   public function update(array $data, int $id);
   public function destroy(int $id);
   public function search(int $company_id,$from, $to, $sort = null, $paginate);
   public function select(int $company_id);
   public function getWhereInIds(array $ids);
   public function getDepartmentEmployeesIds(int $id);

}