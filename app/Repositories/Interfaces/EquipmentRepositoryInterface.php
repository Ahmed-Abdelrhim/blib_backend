<?php
namespace App\Repositories\Interfaces;

interface EquipmentRepositoryInterface
{

    public function index();
    public function store(array $data);
    public function find($id);
    public function update(array $data, $id);
    public function delete($id);
}