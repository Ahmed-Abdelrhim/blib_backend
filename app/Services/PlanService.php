<?php

namespace App\Services;

use App\Repositories\Interfaces\PlanRepositoryInterface;
use App\Services\Interfaces\PlanServiceInterface;

class PlanService implements PlanServiceInterface
{


    private $PlanRepository;

    public function __construct(PlanRepositoryInterface $PlanRepository)
    {
        $this->PlanRepository = $PlanRepository;
    }



    public function store($min_employees, $max_employees, $description,$is_free)
    {
        try {
            $plan = $this->PlanRepository->store($min_employees, $max_employees, $description,$is_free);


            return response()->json([
                'status' => 201,
                'message' => 'Data Updated Successfully',
                'data'   => $plan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $plans = $this->PlanRepository->index();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data'   => $plans
        ], 200);
    }

    public function get(int $id)
    {
        return $this->PlanRepository->get($id);
    }
}
