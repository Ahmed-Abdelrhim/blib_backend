<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EmployeeExcelExportRequest;
use App\Http\Requests\Dashboard\EmployeeSearchArchiveRequest;
use App\Http\Requests\Dashboard\EmployeeSearchRequest;
use App\Http\Requests\Dashboard\EmployeeValidateAddRequest;
use App\Http\Requests\Dashboard\EmployeeValidateIDRequest;
use App\Http\Requests\Dashboard\EmployeeValidateIDsArrayRequest;
use App\Http\Requests\Dashboard\EmployeeValidateRestoreRequest;
use App\Http\Requests\Dashboard\EmployeeValidateSoftDeletedIDRequest;
use App\Http\Requests\Dashboard\EmployeeValidateSoftDeletedIDsArrayRequest;
use App\Services\Interfaces\EmployeeDashboardServiceInterface;


class EmployeeController extends Controller
{

    private $employeeService;

    public function __construct(EmployeeDashboardServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }



    public function index()
    {
        return $this->employeeService->all(auth('sanctum')->user()->company->id);
    }


    public function paginate()
    {
        return $this->employeeService->paginate(auth('sanctum')->user()->company->id);
    }



    public function archive()
    {
        return $this->employeeService->archive(auth('sanctum')->user()->company->id);
    }


    public function archivePaginate()
    {
        return $this->employeeService->archivePaginate(auth('sanctum')->user()->company->id);
    }


    public function store(EmployeeValidateAddRequest $request)
    {
        return $this->employeeService->createOrUpdate($request->validated(), auth('sanctum')->user()->company->id);
    }


    public function update(EmployeeValidateAddRequest $request, $employee_id)
    {
        return $this->employeeService->createOrUpdate($request->validated(), auth('sanctum')->user()->company->id, $employee_id);
    }

    public function search(EmployeeSearchRequest $request)
    {
        return $this->employeeService->search(
            auth('sanctum')->user()->company->id,
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59',
            $request->department_id,
            $request->is_complete,
            $request->sort,
            $request->paginate
        );
    }


    public function searchArchive(EmployeeSearchArchiveRequest $request)
    {
        return $this->employeeService->searchArchive(
            auth('sanctum')->user()->company->id,
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59',
            $request->sort,
            $request->paginate
        );
    }



    /**
     * Display a paginate listing of the resource.
     */
    public function tree()
    {
        return $this->employeeService->allMinimum(auth('sanctum')->user()->company->id);
    }


    public function show(EmployeeValidateIDRequest $request, $id)
    {
        return $this->employeeService->show($id);
    }


    public function archiveShow(EmployeeValidateSoftDeletedIDRequest $request, $id)
    {
        return $this->employeeService->showArchive($id);
    }

    public function destroy(EmployeeValidateIDRequest $request, $id)
    {
        return $this->employeeService->destroy($id);
    }

    public function restore(EmployeeValidateRestoreRequest $request, $id)
    {
        return $this->employeeService->restoreAndUpdate($request->validated(), $id);
    }

    public function showMinimum(EmployeeValidateIDRequest $request, $id)
    {
        return $this->employeeService->getMinimum($id);
    }

    public function select()
    {
        return $this->employeeService->select(auth('sanctum')->user()->company->id);
    }


    public function forceDelete(EmployeeValidateSoftDeletedIDRequest $request, $id)
    {
        return $this->employeeService->forceDelete($id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function multiDelete(EmployeeValidateIDsArrayRequest $request)
    {
        return $this->employeeService->multiDelete($request->ids);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function archiveMultiDelete(EmployeeValidateSoftDeletedIDsArrayRequest $request)
    {
        return $this->employeeService->multiForceDelete($request->ids);
    }

    public function exportTest()
    {
        $file_columns =  [
            'Employee Name',
            'Job Title',
            'Department',
            'Report To',
            'Email Address',
            'Mobile Number',
            'Date of Birth',
            'Gender',
            'Country',
            'Address',
            'Military Status',
            'Job Type',
            'About',
            'Salary',
            'Joined Year',
            'Bio'
        ];
        $file_extension = 'CSV';
        $employees_ids = null;
        // $employees_ids = [2,4,5];
        $filter_array = [
            // 'from' => '2023-04-09',
            'from' => null,
            // 'to' => '2023-06-07',
            'to' => null,
            'is_complete' => null,
            'department_id' => 2,
            'sort' => null,
        ];
        return $this->employeeService->export($file_columns, $file_extension, $employees_ids, $filter_array);
    }


    public function export(EmployeeExcelExportRequest $request)
    {
        $filter_array = $this->handleExcelFilterData($request);

        return $this->employeeService->export($request->file_columns, $request->file_extension, $request->ids, $filter_array);
    }

    private function handleExcelFilterData($request)
    {
        if (is_null($request->from) && is_null($request->to) && is_null($request->department_id) && is_null($request->is_complete) && is_null($request->sort)) {
            return null;
        } else {
            return [
                'from' => $request->from,
                'to' => $request->to,
                'department_id' => $request->department_id,
                'is_complete' => $request->is_complete,
                'sort' => $request->sort,
            ];
        }
    }
}
