<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IndustryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    private $IndustryService;

    public function __construct(IndustryServiceInterface $IndustryService)
    {
        $this->IndustryService = $IndustryService;
    }


    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),
            [
                'title' => 'required|string|unique:industries'
            ]);

        if ($validateData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateData->errors(),
            ], 422);
        }

        return $this->IndustryService->store($request->title);
    }

    public function index()
    {
        return $this->IndustryService->index();
    }
}
