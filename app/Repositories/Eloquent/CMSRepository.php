<?php

namespace App\Repositories\Eloquent;

use App\Models\CMS;
use App\Repositories\Interfaces\CMSRepositoryInterface;

class CMSRepository implements CMSRepositoryInterface
{

    protected $model;

    public function __construct(CMS $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model
            ->get();
    }
    public function get(int $id)
    {
        return $this->model
            ->find($id);
    }
    public function create(array $data)
    {
        return $this->model
            ->create($data);
    }
    public function getWhereAll(array $data)
    {
        return $this->model->where($data)
            ->get();
    }
    public function getWhereFirst(array $data)
    {
        return $this->model->where($data)
            ->first();
    }
    public function update(array $data, int $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }
    public function destroy(int $id)
    {
        return $this->model->find($id)
            ->delete();
    }
}
