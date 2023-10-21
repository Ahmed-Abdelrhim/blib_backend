<?php
namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface
{
    public function store($name, $domain, $industry_id, $logo = '', $plan_id = 0);
    public function get(int $id);
    public function update(int $id,array $data);
    public function subscribeToPlan($company_id, $plan_id);
    public function getDomains();
}