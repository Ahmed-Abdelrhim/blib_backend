<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * PlanRepository constructor.
     *
     * @param Plan $model
     */
    public function __construct(Plan $model)
    {
        $this->model = $model;
    }

    public function get(int $id)
    {
        return $this->model->where('id', $id)
            ->first();
    }
    
    public function store($min_employees, $max_employees, $description,$is_free){
        $plan = $this->model->create([
            'min_employees' => $min_employees,
            'max_employees' => $max_employees,
            'description'   => $description,
            'is_free'   => $is_free
        ]);

        return $plan;
    }

    public function index(){
        $plans = $this->model->orderBy('min_employees', 'ASC')->get();

        return $plans;
    }
}
