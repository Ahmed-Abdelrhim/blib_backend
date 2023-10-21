<?php
namespace App\Services\Interfaces;


interface EmployeeServiceInterface
{
   public function updateEmployeeData($country_code, $phone, $date_of_birth, $profile_image);
   public function getEmployeeCompany( int $employee_id);
}