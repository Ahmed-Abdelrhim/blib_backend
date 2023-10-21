<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\AdminAuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Rules\NotIdenticalToOldPassword;


class AdminAuthController extends Controller
{
    private $AdminAuthService;

    public function __construct(AdminAuthServiceInterface $AdminAuthService)
    {
        $this->AdminAuthService = $AdminAuthService;
    }

    public function login(Request $request)
    {
        $validateEmployee = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validateEmployee->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateEmployee->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        return $this->AdminAuthService->login($credentials);
    }

    public function logout(Request $request)
    {
        return $this->AdminAuthService->logout($request);
    }

    public function verify(Request $request)
    {
        $validateOTP = Validator::make(
            $request->all(),
            [
                'otp' => 'required|integer',
            ]
        );

        if ($validateOTP->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateOTP->errors(),
            ], 422);
        }

        return $this->AdminAuthService->verifyAdminEmail($request->otp);
    }

    public function forgetPassword(Request $request)
    {
        $validateEmployee = Validator::make(
            $request->all(),
            [
                'email' => 'required|email'
            ]
        );

        if ($validateEmployee->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateEmployee->errors(),
            ], 422);
        }


        return $this->AdminAuthService->forgetPassword($request->email);
    }


    public function updatePassword(Request $request)
    {
        $validatePassword = Validator::make(
            $request->all(),
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
                'message' => 'validation error',
                'errors' => $validatePassword->errors(),
            ], 422);
        }

        return $this->AdminAuthService->updatePassword($request->password);
    }

    public function resendOTP(Request $request)
    {
        $validateEmployee = Validator::make(
            $request->all(),
            [
                'type' => 'required|string'
            ]
        );

        if ($validateEmployee->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validation error',
                'errors' => $validateEmployee->errors(),
            ], 422);
        }

        return $this->AdminAuthService->resendOTP($request->type);
    }
}
