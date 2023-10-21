<?php

namespace App\Repositories\Eloquent;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{

    protected $model;
    private $paginate;


    public function __construct(Department $model)
    {
        $this->model = $model;
        $this->paginate = 12;
    }



    /**
     * Display a listing of the resource.
     */
    public function all(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->withCount('employees')
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function paginate(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->withCount('employees')
            ->paginate($this->paginate);
    }


    /**
     * Display a listing of the resource.
     */
    public function allWithDetails(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->withCount('employees')
            ->with(['employees_minimum'])
            ->get();
    }


    /**
     * Display a listing of the resource.
     */
    public function paginateWithDetails(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->withCount('employees')
            ->with(['employees_minimum'])
            ->paginate($this->paginate);
    }



    /**
     * Create resource of specific data.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }


    /**
     * Display the first resource or create .
     */
    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->model
            ->withCount('employees')
            ->find($id);
    }

    /**
     * Display the specified resource.
     */
    public function showWithDetails(int $id)
    {
        return $this->model
            ->withCount('employees')
            ->with(['employees_minimum.reports_to_minimum'])
            ->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, int $id)
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }

    public function getWhereInIds(array $ids)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->withCount('employees')
            ->get();
    }


    public function getDepartmentEmployeesIds(int $id)
    {
        $department = $this->model->find($id);
        return $department->employees()->pluck('id')->toArray();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->model
            ->destroy($id);
    }


    /**
     * Select specific fields from storage.
     */
    public function select(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->select(['id', 'title as name'])
            ->get();
    }




    private function sortBy($query, $sort)
    {
        switch ($sort) {
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            default:
                return $query->orderBy('created_at', 'asc');
        }
    }

    public function search(int $company_id, $from, $to, $sort = null, $paginate = 1)
    {
        // $query = $this->model->whereBetween('created_at', [$from, $to]);
        $query = $this->model->where('company_id',$company_id);
        is_null($from) ? null :  $query->whereBetween('created_at', [$from, $to]);
        $query = $this->sortBy($query, $sort);
        $query = $query->withCount('employees')->with(['employees_minimum']);
        return $paginate == 1 ?  $query->paginate($this->paginate) : $query->get();
    }
}
