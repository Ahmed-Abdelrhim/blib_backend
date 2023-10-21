<?php
namespace App\Repositories\Interfaces;


interface CMSRepositoryInterface
{

   public function all();
   public function get(int $id);
   public function create(array $data);
   public function getWhereAll(array $data);
   public function getWhereFirst(array $data);
   public function update(array $data, int $id);
   public function destroy(int $id);


}