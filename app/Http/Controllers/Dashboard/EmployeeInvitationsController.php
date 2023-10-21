<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EmployeesEmailInvitationsRequest;
use App\Services\Interfaces\EmployeeExcelServiceInterface;

class EmployeeInvitationsController extends Controller
{

    private $employeeExcelService;

    public function __construct(EmployeeExcelServiceInterface $employeeExcelService)
    {
        $this->employeeExcelService = $employeeExcelService;
    }



    public function sendInvitations(EmployeesEmailInvitationsRequest $request)
    {
        $company = auth('sanctum')->user()->company;
         $this->employeeExcelService->sendInvitations($company, $request->email_body);
        return $this->success202();
    }

    public function templateInvitations()
    {
        $company = auth('sanctum')->user()->company;
        return $this->employeeExcelService->getTemplateInvitations($company);
    }

    public function skipInvitations()
    {
        $company = auth('sanctum')->user()->company;
        $this->employeeExcelService->skipInvitations($company);
        return $this->success202();

    }
}
