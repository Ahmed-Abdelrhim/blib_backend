<?php

namespace App\Services;

use App\Mail\OTPEmail;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\OTPRepositoryInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\UploadTrait;

class CompanyService implements CompanyServiceInterface
{
    use UploadTrait;

    private $CompanyRepository;
    private $AdminRepository;
    private $OTPRepository;

    public function __construct(CompanyRepositoryInterface $CompanyRepository, AdminRepositoryInterface $AdminRepository, OTPRepositoryInterface $OTPRepository)
    {
        $this->CompanyRepository = $CompanyRepository;
        $this->AdminRepository = $AdminRepository;
        $this->OTPRepository = $OTPRepository;
    }

    public function register($name, $domain, $industry_id, $hr_name, $email, $password)
    {
        try {


            // Check if a company with the same domain exists
            $existingCompany = $this->CompanyRepository->findByDomain($domain);

            if ($existingCompany) {
                // Check if the admin associated with the existing company is verified
                $existingAdmin = $this->AdminRepository->findByCompanyId($existingCompany->id);

                if ($existingAdmin && $existingAdmin->email_verified_at) {
                    // If the admin is verified, return an error response
                    return response()->json([
                        'status' => 422,
                        'message' => 'Validation error',
                        'errors' => ['domain' => ['The domain is already taken.']],
                    ], 422);
                } else {
                    // If the admin is not verified, remove the admin
                    $this->AdminRepository->delete($existingAdmin->id);
                }
            }


            $company = $this->CompanyRepository->updateOrCreate($name, $domain, $industry_id);
            $hash = Hash::make($password);
            $hr_name = isset($hr_name) ? $hr_name : $name;
            $admin = $this->AdminRepository->store($company->id, $email, $hash, $hr_name);
            $otp = random_int(100000, 999999);

            $this->OTPRepository->store(1, $otp, $email, 0);

            Mail::to($email)->send(new OTPEmail($otp));
            return response()->json([
                'status' => 201,
                'message' => 'Data Updated Successfully',
                'otp'     => $otp,
                'token' => $admin->createToken("API TOKEN", ['otp'])->plainTextToken,
                'data' => $company,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function get(int $id)
    {
        return $this->CompanyRepository->get($id);
    }

    public function updateCompanyLogo($company, $logo)
    {
        $logo_name_path = $this->updateImage($logo, 'Company/Logo', $company->logo);
        $this->CompanyRepository->update($company->id, ['logo' => $logo_name_path]);
        return $this->CompanyRepository->get($company->id);
    }


    public function subscribeToPlan($plan_id)
    {
        $admin = auth('sanctum')->user();
        $this->CompanyRepository->subscribeToPlan($admin->company_id, $plan_id);
        return response()->json([
            'status' => 201,
            'message' => 'Data Updated Successfully',
            'data' => $admin->company->plan,
        ], 201);
    }

    public function getDomains()
    {
        $domains = $this->CompanyRepository->getDomains();
        return response()->json([
            'status' => 200,
            'message' => 'Data Retrieved Successfully',
            'data' => $domains,
        ], 200);
    }
}
