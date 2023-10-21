<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CompanyUpdateLogoRequest;
use App\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CompanyController extends Controller
{

    private $CompanyService;

    public function __construct(CompanyServiceInterface $CompanyService)
    {
        $this->CompanyService = $CompanyService;
    }

    public function register(Request $request)
    {
        $validateData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'domain' => 'required|string',
                'industry_id' => 'required|integer|exists:industries,id',
                'hr_name' => 'string|max:255',
                'email' => 'required|email|unique:admins',
                'password' => [
                    'required',
                    'confirmed',
                    'string',
                    'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9!?@#$%^&*()-_+=<>]+$/',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        //->uncompromised(),
                ],
            ]
        );

        if ($validateData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateData->errors(),
            ], 422);
        }

        $emailDomainOnly = preg_replace('/.+@/', '', $request->email);

        if ($request->domain !== $emailDomainOnly) {

            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => ['email' => ['The email must belong to the domain']],
            ], 422);
        }

        return $this->CompanyService->register($request->name, $request->domain, $request->industry_id, $request->hr_name, $request->email, $request->password);
    }


    public function subscribeToPlan(Request $request)
    {
        $validateData = Validator::make(
            $request->all(),
            [
                'plan_id' => 'required|integer|exists:plans,id'
            ]
        );

        if ($validateData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateData->errors(),
            ], 422);
        }

        return $this->CompanyService->subscribeToPlan($request->plan_id);
    }

    public function getDomains()
    {
        return $this->CompanyService->getDomains();
    }

    public function updateLogo(CompanyUpdateLogoRequest $request)
    {
        $company = $this->CompanyService->updateCompanyLogo(auth('sanctum')->user()->company, $request->logo);
        return $this->success200( $company->logo);
    }

  
}
