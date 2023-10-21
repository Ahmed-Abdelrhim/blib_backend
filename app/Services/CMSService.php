<?php

namespace App\Services;

use App\Http\Resources\Dashboard\CMSListResource;
use App\Models\Employee;
use App\Repositories\Interfaces\CMSRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\CMSServiceInterface;
use App\Traits\ResponseTrait;
use stdClass;

class CMSService implements CMSServiceInterface
{
    use ResponseTrait;

    private $CMSRepository;
    private $employeeRepository;

    public function __construct(CMSRepositoryInterface $CMSRepository, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->CMSRepository = $CMSRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function all()
    {
        return $this->success200(config('cms'));
    }


    public function get(int $id)
    {
        return $this->success200($this->CMSRepository->get($id));
    }

    private function handleEnumResponse(array $enum_data)
    {
        $enum_array = array();
        foreach ($enum_data as $title) {
            array_push($enum_array, array('id' => $title, 'title' => $title));
        }
        return $enum_array;
    }

    public function handleListTypeData(string $type)
    {
        switch ($type) {
            case 'countries':
                return  config('countries');
            case 'currency':
                return  config('currency');
            case 'work_hours':
                return $this->handleEnumResponse(Employee::WORK_HOURS_ENUM);
            default:
                return  CMSListResource::collection($this->CMSRepository->getWhereAll([
                    'type' => $type,
                    'company_id' =>  auth('sanctum')->user()->company->id
                ]));
        }
    }

    public function getListType(string $type)
    {
        return $this->success200($this->handleListTypeData($type));
    }

    public function create(array $data)
    {
        $data['company_id'] =  auth('sanctum')->user()->company->id;
        $this->CMSRepository->create($data);
        return $this->Success201();
    }

    public function update(array $data, int $id)
    {
        $this->CMSRepository->update($data, $id);
        return $this->Success202();
    }

    public function destroy(int $id)
    {
        $this->CMSRepository->destroy($id);
        return $this->Success202();
    }
}
