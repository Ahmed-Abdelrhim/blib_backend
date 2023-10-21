<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CMSValidateDataRequest;
use App\Http\Requests\Dashboard\CMSValidateIDRequest;
use App\Services\Interfaces\CMSServiceInterface;

class CMSController extends Controller
{

    private $CMSService;


    public function __construct(CMSServiceInterface $CMSService)
    {
        $this->CMSService = $CMSService;
 
    }

    public function index()
    {
        return $this->CMSService->all();
    }

    public function type(string $type)
    {
        return $this->CMSService->getListType($type);
    }


    public function store(CMSValidateDataRequest $request)
    {
        return $this->CMSService->create( $request->validated());
    }

    public function show(CMSValidateIDRequest $request, $id)
    {
        return $this->CMSService->get($id);
    }


    public function update(CMSValidateDataRequest $request, $id)
    {
        return $this->CMSService->update( $request->validated(),$id);
    }


    public function destroy(CMSValidateIDRequest $request, $id)
    { 
        return $this->CMSService->destroy($id);
     
    }

}
