<?php

namespace App\Services;

use App\Mail\ForgotPasswordOTPEmail;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\OTPRepositoryInterface;
use App\Services\Interfaces\EmployeeAuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeeAuthService implements EmployeeAuthServiceInterface
{
    private $EmployeeRepository;
    private $OTPRepository;

    public function __construct(EmployeeRepositoryInterface $EmployeeRepository, OTPRepositoryInterface $OTPRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
        $this->OTPRepository = $OTPRepository;
    }

    public function login($credentials)
    {

        try {

            if (!Auth::guard('api')->attempt($credentials)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Email & Password does not match with our record.',
                ], 422);
            }

            $Employee = $this->EmployeeRepository->getEmployeeByEmail($credentials['email']);
            $Employee->image = env('APP_URL') . ('public/storage'). $Employee->image;
            return response()->json([
                'status' => 200,
                'message' => 'Employee Logged In Successfully',
                'data' => $Employee,
                'token' => $Employee->createToken("API TOKEN", ['employee'])->plainTextToken,
            ], 200);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged out',
        ], 200);
    }

    public function updatePassword($password)
    {
        try {

            $id = auth('sanctum')->user()->id;
            $hash = Hash::make($password);

            $this->EmployeeRepository->updatePassword($id, $hash);
            $this->EmployeeRepository->updateIsFirstTime($id, 0);

            return response()->json([
                'status' => 200,
                'message' => 'Password Updated Successfully',
            ], 200);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function forgetPassword($email)
    {
        $Employee = $this->EmployeeRepository->getEmployeeByEmail($email);
        if ($Employee) {
            $this->OTPRepository->deleteByEmail($email, 2);
            $otp = random_int(10000, 99999);
            $this->OTPRepository->store(2, $otp, $email, 0);
            Mail::to($email)->send(new ForgotPasswordOTPEmail($otp));
            return response()->json([
                'status' => 200,
                'otp' => $otp,
                'message' => 'OTP Sent Successfully',
                'token' => $Employee->createToken("API TOKEN", ['otp'])->plainTextToken,
            ], 200);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'Please Enter a valid Email',
            ], 422);
        }
    }

    public function verifyOTP($otp)
    {
        try {
            $email = auth('sanctum')->user()->email;

            $current_otp = $this->OTPRepository->getOTPByEmail($email, 2);

            if ($otp != $current_otp->otp || $current_otp->attempts >= 5) {
                $this->OTPRepository->editOTP($email, $current_otp->otp, 2);
                return response()->json([
                    'status' => 422,
                    'message' => 'Invalid OTP',
                ], 422);
            }

            $Employee = $this->EmployeeRepository->getEmployeeByEmail($email);
            $this->OTPRepository->delete($current_otp->id);

            return response()->json([
                'status' => 200,
                'message' => 'OTP Verified Successfully',
                'data' => $Employee,
                'token' => $Employee->createToken("API TOKEN", ['employee'])->plainTextToken,
            ], 200);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function resendOTP()
    {
        $email = auth('sanctum')->user()->email;
        $this->OTPRepository->deleteByEmail($email, 2);
        $otp = random_int(10000, 99999);
        $this->OTPRepository->store(2, $otp, $email, 0);

        Mail::to($email)->send(new ForgotPasswordOTPEmail($otp));

        return response()->json([
            'status' => 200,
            'otp' => $otp,
            'message' => 'OTP Sent Successfully',
        ], 200);
    }
}
