<?php
namespace App\Repositories\Interfaces;

interface PlanRepositoryInterface
{
    public function get(int $id);
    public function store($min_employees, $max_employees, $description,$is_free);
    public function index();
}