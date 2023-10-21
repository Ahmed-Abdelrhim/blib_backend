<?php

namespace App\Services;

use App\Exports\DepartmentExport;
use App\Http\Resources\Dashboard\DepartmentListAllEmployeesResource;
use App\Http\Resources\Dashboard\DepartmentListResource;
use App\Http\Resources\Dashboard\DepartmentSingleResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Services\Interfaces\EmployeeDashboardServiceInterface;
use App\Services\Interfaces\EmployeeServiceInterface;
use App\Traits\ExcelExportTrait;
use App\Traits\ResponseTrait;


use function GuzzleHttp\default_ca_bundle;

class DepartmentService implements DepartmentServiceInterface
{
    use ResponseTrait, ExcelExportTrait;

    private $employeeService;
    private $employeeRepository;
    private $departmentRepository;

    public function __construct(
        EmployeeDashboardServiceInterface $employeeService,
        DepartmentRepositoryInterface $departmentRepository,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->employeeService = $employeeService;
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function all(int $company_id)
    {
        return $this->success200(DepartmentListResource::collection($this->departmentRepository
            ->allWithDetails($company_id))
            ->response()->getData(true));
    }



    public function paginate(int $company_id)
    {
        return $this->success200(DepartmentListResource::collection($this->departmentRepository
            ->paginateWithDetails($company_id))
            ->response()->getData(true));
    }

    public function search($company_id, $from, $to, $sort = null, $paginate = 1)
    {
        return $this->success200(DepartmentListResource::collection($this->departmentRepository
            ->search($company_id, $from, $to, $sort, $paginate))
            ->response()->getData(true));
    }


    /**
     * Display a listing of the resource.
     */
    public function allWithDetails(int $company_id)
    {
        return $this->success200(DepartmentListAllEmployeesResource::collection($this->departmentRepository
            ->allWithDetails($company_id))
            ->response()->getData(true));
    }


    /**
     * Display a listing of the resource.
     */
    public function paginateWithDetails(int $company_id)
    {
        return $this->success200(DepartmentListAllEmployeesResource::collection($this->departmentRepository
            ->paginateWithDetails($company_id))
            ->response()->getData(true));
    }


    /**
     * Display a listing of the resource.
     */
    public function select(int $company_id)
    {
        return $this->success200($this->departmentRepository->select($company_id));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function create(array $data)
    {
        $department = $this->departmentRepository->create([
            'company_id' => auth('sanctum')->user()->company->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null
        ]);

        isset($data['employee_ids']) ? $this->employeeRepository->updateWhereIn($data['employee_ids'], ['department_id' => $department->id]) : null;
        return $this->success201();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->success200(new DepartmentSingleResource($this->departmentRepository
            ->showWithDetails($id)));
    }

    /**
     * Display the specified resource.
     */
    public function getMinimum(int $id)
    {
        return $this->success200(new DepartmentListResource($this->departmentRepository
            ->show($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, int $id)
    {
        isset($data['added_employee_ids']) ?  $this->employeeRepository->updateWhereIn($data['added_employee_ids'], ['department_id' => $id]) : null;
        isset($data['deleted_employee_ids']) ? $this->employeeService->multiDelete($data['deleted_employee_ids']) : null;

        $this->departmentRepository->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null
        ], $id);

        return $this->success202();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $department_employees_ids = $this->departmentRepository->getDepartmentEmployeesIds($id);
        $this->employeeService->multiDelete($department_employees_ids);
        $this->departmentRepository->destroy($id);
        return $this->success202();
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function multiDelete(array $ids)
    {
        foreach ($ids as $id) {
            $department_employees_ids = $this->departmentRepository->getDepartmentEmployeesIds($id);
            $this->employeeService->multiDelete($department_employees_ids);
            $this->departmentRepository->destroy($id);
        }
        return $this->success202();
    }


    public function export(array $headings, string $extension, array $ids = null, array $filter = null)
    {
        $file_data = $this->getExcelData($ids, $filter);
        return $this->excelExport(DepartmentExport::class, $headings, $extension, $file_data, 'departments');
    }

    private function getExcelData(array $ids = null, array $filter = null)
    {
        // $company_id = auth('sanctum')->user()->company->id ?? 1;
        $company_id = auth('sanctum')->user()->company->id;
        if ($ids) {
            return $this->departmentRepository->getWhereInIds($ids);
        } else if ($filter) {
            return $this->departmentRepository->search($company_id, $filter['from'], $filter['to'], $filter['sort'], 0);
        } else {
            return $this->departmentRepository->all($company_id);
        }
    }
}
