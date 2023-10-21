<?php

namespace App\Services;

use App\Http\Resources\Dashboard\EmployeeListResource;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\EmployeeServiceInterface;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;


class EmployeeService implements EmployeeServiceInterface
{
    use UploadTrait,ResponseTrait;

    private $EmployeeRepository;

    public function __construct(EmployeeRepositoryInterface $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }

    
        /**
     * Display a listing of the resource.
     */
    public function archive(int $company_id)
    {
        return $this->success200($this->EmployeeRepository->archive($company_id));
        
    }
    

    public function updateEmployeeData($country_code, $phone, $date_of_birth, $profile_image)
    {
        try {

            $id = auth('sanctum')->user()->id;

            $this->EmployeeRepository->updateEmployeeData($id, $country_code, $phone, $date_of_birth);

            if (isset($profile_image)) {
                $old_profile_image = auth('sanctum')->user()->image;
                //$profile_image_path = $this->upload($profile_image, $old_profile_image, 'Users/Profile');
                $profile_image_path = $this->updateImageWithResize($profile_image, 'Users/Profile', $old_profile_image, 500, 500);
                $this->EmployeeRepository->updateEmployeeProfileImage($id, $profile_image_path);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }



    public function getEmployeeCompany(int $employee_id)
    {
        $employee = $this->EmployeeRepository->getWithDetails($employee_id);
        return $employee->title->department->company;
    }

    



}
