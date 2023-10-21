<?php

namespace App\Services;

use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use App\Traits\ResponseTrait;
use App\Http\Resources\Dashboard\EquipmentSingleResource;
use Carbon\Carbon;

class EquipmentService
{
    use ResponseTrait;


    private $equipment_repository;

    public function __construct(EquipmentRepositoryInterface $equipment_repository)
    {
        $this->equipment_repository = $equipment_repository;
    }

    

    public function index($filter = null)
    {
        return $this->success200($this->equipment_repository->index($filter));
    }



    public function store($data)
    {
        try {
            $equipment = $this->equipment_repository->store($data);
            return $this->success201(new EquipmentSingleResource($equipment));
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }



    public function update($data, $id)
    {
        $equipment = $this->equipment_repository->update($data, $id);
        return $this->Success202(new EquipmentSingleResource($equipment));
    }


    public function show($id)
    {
        return $this->success200(new EquipmentSingleResource($this->equipment_repository->find($id)));
    }


    public function destroy(int $id){
        $this->equipment_repository->delete($id);
        return $this->success202();
    }



    public function assign($data)
    {
        $taken_at = ($data['taken_at']) ?? Carbon::now()->format('Y-m-d');
        $this->equipment_repository->assign($data['equipment_id'], $data['employee_id'], $taken_at);
        return $this->success200();
    }



    public function takeOff($data)
    {
        $returned_at = ($data['returned_at']) ?? Carbon::now()->format('Y-m-d');
        $this->equipment_repository->takeOff($data['employee_equipment_id'], $returned_at);
        return $this->success200();
    }



    


}
