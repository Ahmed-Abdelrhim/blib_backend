<?php
namespace App\Services\Interfaces;

interface PlanServiceInterface
{
   public function get(int $id);
   public function store($min_employees, $max_employees, $description,$is_free);
   public function index();
}