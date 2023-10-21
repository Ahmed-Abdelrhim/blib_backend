<?php

namespace App\Repositories\Eloquent;

use App\Models\Equipment;
use App\Models\EmployeeEquipment;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use Exception;
use Carbon\Carbon;


class EquipmentRepository implements EquipmentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;
    protected $company;


    /**
     * PlanRepository constructor.
     *
     * @param Plan $model
     */
    public function __construct(Equipment $equipment)
    {
        $this->model = $equipment;
        $this->company = (auth('sanctum')->user()->company) ?? null;

        if (!$this->company)
            throw new Exception("We need a company to complete the process!");

    }

    public function index($filter = null)
    {
        $result = $this->model->orderBy('name', 'ASC');

         if ($filter === 'available') {
            $result = $result->whereNull('in_use_by');
        }


        elseif ($filter === 'not_available') {
            $result = $result->whereNotNull('in_use_by');
        } 


        return count($result->get());
    }

    public function store(array $data)
    {
        $data['company_id'] = $this->company->id;
        $equipment = $this->model->create($data);

        if(isset($data['in_use_by'])){
            $taken_at = ($data['taken_at']) ?? Carbon::now()->format('Y-m-d');
            $this->assign($equipment->id, $data['in_use_by'], $taken_at);
        }

        return $equipment;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $equipment = $this->model->findOrFail($id);

        if(isset($data['in_use_by'])){
            $taken_at = ($data['taken_at']) ?? Carbon::now()->format('Y-m-d');
            $this->assign($equipment->id, $data['in_use_by'], $taken_at);
            unset($data['in_use_by']);
        }

        $equipment->update($data);
        return $equipment;
    }

    public function delete($id)
    {

        if($this->checkAuthority($id)){
            $equipment = $this->model->findOrFail($id);
            $equipment->assignees()->delete();
            return $equipment->delete();
        }

        else return response()->json([
                'status' => 500,
                'message' => 'The selected equipment does not belong to the company.',
            ], 500);

    }


    public function assign($equipment_id, $employee_id, $taken_at = null)
    {
        $equipment = $this->model->findOrFail($equipment_id);

        if($equipment->in_use_by && $equipment->in_use_by != $employee_id) {
            return response()->json([
                'status' => 500,
                'message' => 'This equipment is used by another employee!',
            ], 500);
        }


        $equipment->in_use_by = $employee_id;
        $equipment->save();

        EmployeeEquipment::updateOrCreate(
            ['equipment_id' => $equipment_id],
            ['employee_id' => $employee_id, 'taken_at' => $taken_at, 'returned_at' => null]
        );

    }


    public function takeOff($employee_equipment_id, $returned_at = null){
        $employee_equipment = EmployeeEquipment::find($employee_equipment_id);

        $employee_equipment->update([
            'returned_at' => $returned_at,
        ]);

        $employee_equipment->equipment()->update([
            'in_use_by' => null,
        ]);
    }


    protected function checkAuthority($equipment_id){
        return Equipment::where('id', $equipment_id)
            ->where('company_id', auth('sanctum')->user()->company->id)
            ->exists();
    }

}
