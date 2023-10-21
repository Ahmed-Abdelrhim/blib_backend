<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\EquipmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Dashboard\EquipmentRequest;
use App\Http\Requests\Dashboard\AssignEquipmentRequest;
use App\Http\Requests\Dashboard\TakeOffEquipmentRequest;

class EquipmentController extends Controller
{

    private $equipment_service;

    public function __construct(EquipmentService $equipment_service)
    {
        $this->equipment_service = $equipment_service;
    }


    public function index(Request $request)
    {

        return $this->equipment_service->index($request->input('filter'));

        $filter = $request->input('filter');

        if ($filter === 'available') {
            return $this->equipment_service->getAvailableEquipments();
        } elseif ($filter === 'not_available') {
            return $this->equipment_service->getNotAvailableEquipments();
        } else {
            return$this->equipment_service->index($request->all());
        }
    }


    public function store(EquipmentRequest $request)
    {
        return $this->equipment_service->store($request->all());
    }



    public function update(EquipmentRequest $request, $id)
    {
        return $this->equipment_service->update($request->all(), $id);
    }


    public function show($id)
    {
        return $this->equipment_service->show($id);
    }


    public function assign(AssignEquipmentRequest $request)
    {
        return $this->equipment_service->assign($request->all());
    }


    public function takeOff(TakeOffEquipmentRequest $request)
    {
        return $this->equipment_service->takeOff($request->all());
    }


    public function destroy($id)
    {
        return $this->equipment_service->destroy($id);
    }

}
