<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PlanServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    private $PlanService;

    public function __construct(PlanServiceInterface $PlanService)
    {
        $this->PlanService = $PlanService;
    }


    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),
            [
                'min_employees' => 'required|integer',
                'max_employees' => 'required|integer',
                'description' => 'required|string',
                'is_free' => 'required|in:0,1'
            ]);

        if ($validateData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateData->errors(),
            ], 422);
        }

        return $this->PlanService->store($request->min_employees, $request->max_employees, $request->description,$request->is_free);
    }

    public function index()
    {
        return $this->PlanService->index();
    }
}
