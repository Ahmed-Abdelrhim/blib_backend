<?php
namespace App\Services\Interfaces;

interface CompanyServiceInterface
{
   public function register($name, $domain, $industry_id, $hr_name, $email, $password);
   public function get(int $id);
   public function updateCompanyLogo($company, $logo);
   public function subscribeToPlan($plan_id);
   public function getDomains();
}