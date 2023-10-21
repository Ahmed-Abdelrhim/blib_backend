<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmployeeUpdateDataRequest;
use App\Services\Interfaces\EmployeeServiceInterface;


class EmployeeController extends Controller
{
    private $EmployeeService;

    public function __construct(EmployeeServiceInterface $EmployeeService)
    {
        $this->EmployeeService = $EmployeeService;
    }

    public function updateEmployeeData(EmployeeUpdateDataRequest $request)
    {
        return $this->EmployeeService->updateEmployeeData($request->country_code, $request->phone, $request->date_of_birth, $request->file('profile_image'));
    }
}
