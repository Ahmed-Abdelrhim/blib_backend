<?php

namespace App\Services;

use App\Exports\EmployeeExport;
use App\Http\Resources\Dashboard\EmployeeArchiveListResource;
use App\Http\Resources\Dashboard\EmployeeDetailsResource;
use App\Http\Resources\Dashboard\EmployeeListResource;
use App\Http\Resources\Dashboard\EmployeeMinimumResource;
use App\Http\Resources\Dashboard\EmployeeSelectResource;
use App\Http\Resources\Dashboard\EmployeeSingleArchiveResource;
use App\Http\Resources\Dashboard\EmployeeSingleResource;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\EmployeeDashboardServiceInterface;
use App\Services\Interfaces\EmployeeServiceInterface;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Str;
use App\Traits\ExcelExportTrait;

class EmployeeDashboardService implements EmployeeDashboardServiceInterface
{
    use UploadTrait, ExcelExportTrait, ResponseTrait;

    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function archive(int $company_id)
    {
        return $this->success200(EmployeeArchiveListResource::collection($this->employeeRepository
            ->archive($company_id))
            ->response()->getData(true));
    }

    public function archivePaginate(int $company_id)
    {
        return $this->success200(EmployeeArchiveListResource::collection($this->employeeRepository
            ->archivePaginate($company_id))
            ->response()->getData(true));
    }

    public function all(int $company_id)
    {
        return $this->success200(EmployeeListResource::collection($this->employeeRepository
            ->all($company_id))
            ->response()->getData(true));
    }


    public function paginate(int $company_id)
    {
        return $this->success200(EmployeeListResource::collection($this->employeeRepository
            ->paginate($company_id))
            ->response()->getData(true));
    }


    public function search(int $company_id, $from, $to, $department_id, $is_complete, $sort, $paginate = 1)
    {
        return $this->success200(EmployeeListResource::collection($this->employeeRepository
            ->search($company_id, $from, $to, $department_id, $is_complete, $sort, $paginate))
            ->response()->getData(true));
    }

    public function searchArchive(int $company_id, $from, $to, $sort, $paginate = 1)
    {
        return $this->success200(EmployeeArchiveListResource::collection($this->employeeRepository
            ->searchArchive($company_id, $from, $to, $sort, $paginate))
            ->response()->getData(true));
    }

    public function allMinimum(int $company_id)
    {
        return $this->success200($this->employeeRepository->allMinimum($company_id));
    }

    public function show(int $id)
    {
        return $this->success200(new EmployeeDetailsResource($this->employeeRepository->get($id)));
    }

    public function showArchive(int $id)
    {
        return $this->success200(new EmployeeSingleArchiveResource($this->employeeRepository->get($id)));
    }


    public function getMinimum(int $id)
    {
        return $this->success200(new EmployeeMinimumResource($this->employeeRepository->get($id)));
    }

    public function select(int $company_id)
    {
        return $this->success200(($this->employeeRepository->select($company_id)));
    }

    public function create(array $data, int $company_id)
    {

        // if (isset($data['personal_information'])) {
        //     $this->handlePersonalInformationData($data, $company_id);
        // }

        // if (isset($data['work_information'])) {
        //     $this->handleWorkInformationData($data, $company_id);
        // }

        // if (isset($data['equipments'])) {
        //     $this->handleEquipmentsData($data, $company_id);
        // }

        // if (isset($data['papers'])) {
        //     $this->handlePapersData($data, $company_id);
        // }

        // if (isset($data['vacations'])) {
        //     $this->handleVacationsData($data, $company_id);
        // }

        // return $this->success201();
    }



    public function createOrUpdate(array $data, int $company_id, int $employee_id = null)
    {

        $this->handleData($data, $company_id, $employee_id);
        ($employee_id) ? $this->employeeRepository->update($data, $employee_id): $this->employeeRepository->create($data);

        return $this->success201();
    }



    private function handleData(array &$data, int $company_id, int $employee_id = null)
    {   

        $mergedData = [];

        if (isset($data['personal_information'])) {
            $personalInformation = $data['personal_information'];
            $personalInformation['company_id'] = $company_id;
            $personalInformation['is_personal_information_complete'] = 1;
            $mergedData = array_merge($mergedData, $personalInformation);
        }


        if (isset($data['work_information'])) {
            $workInformation = $data['work_information'];
            $mergedData = array_merge($mergedData, $workInformation);
        }

        // if (isset($data['equipments'])) {
        //     $equipments = $data['equipments'];
        //     $mergedData = array_merge($mergedData, $equipments);
        // }

        // if (isset($data['papers'])) {
        //     //
        // }

        // if (isset($data['vacations'])) {

        //     $current_year = Carbon::now()->format('Y');
        //     $vacationData = [
        //         'vacation_activate_at' => Carbon::parse($data['joined_at'])->addMonths($data['vacations']['vacation_activate_id']),
        //         'vacation_expire_carry_at' => $currentYear . '-' . $data['vacations']['vacation_expire_carry_id'] . '-31',
        //     ];
        //     $mergedData = array_merge($mergedData, $vacationData);
        //     // unset($data['vacation_activate_at'], $data['vacation_expire_carry_at']);
        // }

        $data = $mergedData;
    }
    

    public function destroy(int $id)
    {
        $this->handleDeleteLogic($id);
        return $this->success202();
    }


    public function forceDelete(int $id)
    {
        $this->forceDelete($id);
        return $this->success202();
    }

    public function multiDelete(array $ids)
    {
        foreach ($ids as $id) {
            $this->handleDeleteLogic($id);
        }
        return $this->success202();
    }

    public function multiForceDelete(array $ids)
    {
        foreach ($ids as $id) {
            $this->handleForceDeleteLogic($id);
        }
        return $this->success202();
    }

    public function restoreAndUpdate(array $data, int $id)
    {
        $data['deleted_by_id'] = null;
        $this->employeeRepository->update($data, $id);
        $this->handleRestoreLogic($id);
        return $this->success202();
    }

    public function restore(int $id)
    {
        $this->handleRestoreLogic($id);
        return $this->success202();
    }

    public function multiRestore(array $ids)
    {
        foreach ($ids as $id) {
            $this->handleRestoreLogic($id);
        }
        return $this->success202();
    }




    public function export(array $headings, string $extension, array $ids = null, array $filter = null)
    {
        $file_data = $this->getExcelData($ids, $filter);
        return $this->excelExport(EmployeeExport::class, $headings, $extension, $file_data, 'employees');
    }


    private function getExcelData(array $ids = null, array $filter = null)
    {
        $company_id = auth('sanctum')->user()->company->id ?? 1;
        if ($ids) {
            return $this->employeeRepository->getWhereInIds($ids);
        } else if ($filter) {
            return $this->employeeRepository->search($company_id, $filter['from'], $filter['to'], $filter['department_id'], $filter['is_complete'], $filter['sort'], 0);
        } else {
            return $this->employeeRepository->all($company_id);
        }
    }


    private function handleDeleteLogic(int $id)
    {
        $employee = $this->employeeRepository->getMinimum($id);

        $this->employeeRepository->updateWhere(
            ['reports_to_id' => $employee->id],
            ['reports_to_id' => $employee->reports_to_id]
        );

        $this->employeeRepository->update(['deleted_by_id' => auth('sanctum')->id()], $id);
        $this->employeeRepository->destroy($id);
    }

    private function handleForceDeleteLogic(int $id)
    {
        $this->employeeRepository->forceDelete($id);
    }

    private function handleRestoreLogic(int $id)
    {
        $this->employeeRepository->restore($id);
    }
}
