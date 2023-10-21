<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\DepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DepartmentDataRequest;
use App\Http\Requests\Dashboard\DepartmentExcelExportRequest;
use App\Http\Requests\Dashboard\DepartmentSearchRequest;
use App\Http\Requests\Dashboard\DepartmentValidateArrayIDsRequest;
use App\Http\Requests\Dashboard\DepartmentValidateIDRequest;
use App\Http\Requests\Dashboard\DepartmentValidateIDsArrayRequest;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ResponseTrait;

    private $departmentService;

    public function __construct(DepartmentServiceInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->departmentService->all(auth('sanctum')->user()->company->id);
    }

    /**
     * Display a paginate listing of the resource.
     */
    public function paginate()
    {
        return $this->departmentService->paginate(auth('sanctum')->user()->company->id);
    }

    /**
     * Display a paginate listing of the resource.
     */
    public function select()
    {
        return $this->departmentService->select(auth('sanctum')->user()->company->id);
    }



    /**
     * Search resource.
     */
    public function search(DepartmentSearchRequest $request)
    {
        return $this->departmentService->search(auth('sanctum')->user()->company->id,$request->from . ' 00:00:00', $request->to . ' 23:59:59', $request->sort, $request->paginate);
    }



    public function exportTest()
    {
        $file_columns =  [
            'Department Name',
            'Employees No',
            'Description'
        ];
        $file_extension = 'CSV';
        $ids = null;
        $ids = [2, 4, 5];
        // $filter_array = null;
        $filter_array = [
            'from' => '2023-04-09',
            'to' => '2023-06-07',
            'sort' => null,
        ];
        return $this->departmentService->export($file_columns, $file_extension, $ids, $filter_array);
    }


 
    public function export(DepartmentExcelExportRequest $request)
    {
     
        $filter_array = $this->handleExcelFilterData($request); 
        return $this->departmentService->export(
            $request->file_columns,
            $request->file_extension,
            $request->ids,
            $filter_array
        );
    }

    private function handleExcelFilterData($request)
    {
        if (is_null($request->from) && is_null($request->to) && is_null($request->sort)) {
           return null;
        } else {
            return [
                'from' => $request->from,
                'to' => $request->to,
                'sort' => $request->sort,
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentDataRequest $request)
    {
        return $this->departmentService->create($request->validated());
    }


    /**
     * Display the specified resource.
     */
    public function show(DepartmentValidateIDRequest $request, $id)
    {
        return $this->departmentService->show($id);
    }


    /**
     * Display the specified resource.
     */
    public function showMinimum(DepartmentValidateIDRequest $request, $id)
    {
        return $this->departmentService->getMinimum($id);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentDataRequest $request, int $id)
    {
        return $this->departmentService->update($request->validated(), $id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentValidateIDRequest $request, $id)
    {
        return $this->departmentService->destroy($id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function multiDelete(DepartmentValidateIDsArrayRequest $request)
    {
        return $this->departmentService->multiDelete($request->ids);
    }
}
