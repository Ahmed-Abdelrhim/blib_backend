<?php

namespace App\Services;


use App\Http\Resources\Dashboard\EmployeeSelectResource;
use App\Models\Department;
use App\Models\Employee;
use App\Repositories\Interfaces\CMSRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\CMSServiceInterface;
use App\Services\Interfaces\DropdownServiceInterface;
use App\Traits\ResponseTrait;

class DropdownService implements DropdownServiceInterface
{
    use ResponseTrait;

    private $departmentRepository;
    private $employeeRepository;
    private $cmsService;

    public function __construct(DepartmentRepositoryInterface $departmentRepository,
    EmployeeRepositoryInterface $employeeRepository,
    CMSServiceInterface $cmsService)
    {
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
        $this->cmsService = $cmsService;
    }

    private function handleEnumResponse(array $enum_data)
    {
        $enum_array = array();
        foreach ($enum_data as $title) {
            array_push($enum_array, array('id' => $title, 'title' => $title));
        }
        return $enum_array;
    }



    public function dropdown()
    {
        $company_id = auth('sanctum')->user()->company->id;

        $data = [
            'department_excel_extensions' => $this->handleEnumResponse(Department::EXCEL_EXTENSION),
            'department_excel_columns' => $this->handleEnumResponse(Department::EXCEL_HEADING),
            'employee_excel_extensions' => $this->handleEnumResponse(Employee::EXCEL_EXTENSION),
            'employee_excel_columns' => $this->handleEnumResponse(Employee::EXCEL_HEADING),
            'departments' => $this->departmentRepository->select($company_id),
            'employees' => $this->employeeRepository->select($company_id),
            'employees_archive' => $this->employeeRepository->selectArchive($company_id),
            'gender' => $this->cmsService->handleListTypeData('gender'),
            'military_status' => $this->cmsService->handleListTypeData('military_status'),
            'work_hours' => $this->cmsService->handleListTypeData('work_hours'),
            'equipment_types' => $this->cmsService->handleListTypeData('equipment_types'),
            'countries' => $this->cmsService->handleListTypeData('countries'),
            'currency' => $this->cmsService->handleListTypeData('currency'),
        ];


        return $this->success200($data);

    }
}