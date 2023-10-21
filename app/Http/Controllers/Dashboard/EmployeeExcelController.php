<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\EmployeeExcelReviewRequest;
use App\Http\Requests\Dashboard\EmployeeExcelJsonStoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EmployeesEmailInvitationsRequest;
use App\Services\Interfaces\EmployeeExcelServiceInterface;

class EmployeeExcelController extends Controller
{

    private $employeeExcelService;

    public function __construct(EmployeeExcelServiceInterface $employeeExcelService)
    {
        $this->employeeExcelService = $employeeExcelService;
    }



    public function importExcelReview(EmployeeExcelReviewRequest $request)
    {
        return $this->employeeExcelService->importExcelReview($request->employees_file);
    }


    public function jsonExcelSave(EmployeeExcelJsonStoreRequest $request)
    {
        $data = collect(json_decode($request->employees_json, true));

        return $this->employeeExcelService->jsonExcelSave($data);
    }

    
    public function getTemplateExcel()
    {
        return $this->success200('/templates/excel/blip_employees_template.xlsx');
    }


    // public function sendInvitations(EmployeesEmailInvitationsRequest $request)
    // {
    //      $this->employeeExcelService->sendInvitations(auth('sanctum')->user()->company, $request->email_body);
    //     return $this->success202();
    // }

    public function templateInvitations()
    {
        return $this->employeeExcelService->getTemplateInvitations(auth('sanctum')->user()->company);
    }
}
