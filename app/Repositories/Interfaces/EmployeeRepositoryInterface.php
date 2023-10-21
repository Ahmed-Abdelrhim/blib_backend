<?php

namespace App\Repositories\Interfaces;


interface EmployeeRepositoryInterface
{

    public function create(array $data);
    public function createWithDetails(array $data, array $equipments_array, array $papers_array);
    public function firstOrCreate(array $data);
    public function all(int $company_id);
    public function allMinimum(int $company_id);
    public function paginate(int $company_id);
    public function archive(int $company_id);
    public function archivePaginate(int $company_id);
    public function groupBy(string $column);
    public function getWhereFirst(array $data);
    public function getAllWhereDomain(string $value);
    public function getEmailsInvitations(string $subdomain);
    public function get(int $id);
    public function getMinimum(int $id);
    public function getWithDetails(int $id);
    public function getWhereInIds(array $ids);
    public function getWhereAll(array $data);
    public function getWhereAllMinimum(array $data);
    public function getEmployeeByEmail($email);
    public function update(array $data, int $id);
    public function updateWhere(array $condition, array $data);
    public function updateWhereIn(array $ids, array $data);
    public function updatePassword($id, $hash);
    public function updateIsFirstTime($id, $is_first_time);
    public function updateEmployeeData($id, $country_code, $phone, $date_of_birth);
    public function updateEmployeeProfileImage($id, $profile_image);
    public function select(int $company_id);
    public function selectArchive(int $company_id);
    public function destroy(int $id);
    public function softDelete(int $id);
    public function forceDelete(int $id);
    public function multiDelete(array $ids);
    public function restore(int $id);
    public function search(int $company_id, $from, $to, $department_id, $is_complete, $sort, $paginate = 1);
    public function searchArchive(int $company_id, $from, $to, $sort, $paginate = 1);
}
