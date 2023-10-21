<?php
namespace App\Services\Interfaces;

interface CMSServiceInterface
{
   public function all();
   public function get(int $id);
   public function handleListTypeData(string $type);
   public function getListType(string $type);
   public function create(array $data);
   public function update(array $data, int $id);
   public function destroy(int $id);
}