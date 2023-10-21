<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\EmployeeAuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Rules\NotIdenticalToOldPassword;


class AuthController extends Controller
{
    private $EmployeeAuthService;

    public function __construct(EmployeeAuthServiceInterface $EmployeeAuthService)
    {
        $this->EmployeeAuthService = $EmployeeAuthService;
    }

    public function login(Request $request)
    {
        $validateEmployee = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

        if ($validateEmployee->fails()) {
            return response()->json([
                'status' => 422,
                'message' => implode(",",$validateEmployee->messages()->all()),
                'errors' => $validateEmployee->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        return $this->EmployeeAuthService->login($credentials);
    }

    public function logout(Request $request)
    {
        return $this->EmployeeAuthService->logout($request);
    }

    public function updatePassword(Request $request)
    {
        $validatePassword = Validator::make($request->all(),
            [
                'password' => [
                    'required',
                    'confirmed',
                    'string',
                    'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9!?@#$%^&*()-_+=<>]+$/',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                        //->uncompromised(),
                        new NotIdenticalToOldPassword,
                ],
            ]);

        if ($validatePassword->fails()) {
            return response()->json([
                'status' => 422,
                'message' => implode(",",$validatePassword->messages()->all()),
                'errors' => $validatePassword->errors(),
            ], 422);
        }

        return $this->EmployeeAuthService->updatePassword($request->password);
    }

    public function forgetPassword(Request $request)
    {
        $validateEmail = Validator::make($request->all(),
            [
                'email' => 'required|email|exists:employees,email',
            ]);

        if ($validateEmail->fails()) {
            return response()->json([
                'status' => 422,
                'message' => implode(",",$validateEmail->messages()->all()),
                'errors' => $validateEmail->errors(),
            ], 422);
        }

        return $this->EmployeeAuthService->forgetPassword($request->email);
        
    }

    public function verify(Request $request)
    {
        $validateOTP = Validator::make($request->all(),
        [
            'otp' => 'required|integer',
        ]);

    if ($validateOTP->fails()) {
        return response()->json([
            'status' => 422,
            'message' => 'Invalid OTP',
            'errors' => $validateOTP->errors(),
        ], 422);
    }

        return $this->EmployeeAuthService->verifyOTP($request->otp);
    }

    public function resendOTP()
    {
        return $this->EmployeeAuthService->resendOTP();
    }
}
