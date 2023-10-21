<?php

namespace App\Services;

use App\Mail\ForgotPasswordOTPEmail;
use App\Mail\OTPEmail;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\OTPRepositoryInterface;
use App\Services\Interfaces\AdminAuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuthService implements AdminAuthServiceInterface
{
    private $AdminRepository;
    private $OTPRepository;

    public function __construct(AdminRepositoryInterface $AdminRepository, OTPRepositoryInterface $OTPRepository)
    {
        $this->AdminRepository = $AdminRepository;
        $this->OTPRepository = $OTPRepository;
    }

    public function login($credentials)
    {

        try {

            if (!Auth::guard('admin')->attempt($credentials)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'You have entered an invalid Email or password',
                ], 401);
            }

            $Admin = $this->AdminRepository->getAdminByEmailWithCompany($credentials['email']);

            // $plan = $Admin->company->plan_id;
            // $is_imported = $Admin->company->is_imported;
            // $steps = 'select_plan';

            // if ($plan != 0) {
            //     $steps = 'import_excel';
            // }
            // if ($is_imported != 0) {
            //     $steps = 'welcome';
            // }

            $steps = $this->getLoginStep($Admin);


            if (isset($Admin->email_verified_at)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Admin Logged In Successfully',
                    'is_verified' => 1,
                    'steps' => $steps,
                    'data' => $Admin,
                    'token' => $Admin->createToken("API TOKEN", ['admin'])->plainTextToken,
                ], 200);
            } else {
                $current_otp = $this->OTPRepository->getOTPByEmail($credentials['email'], 1);
                $this->OTPRepository->delete($current_otp->id);
                $otp = random_int(100000, 999999);
                $this->OTPRepository->store(1, $otp, $credentials['email'], 0);
                Mail::to($credentials['email'])->send(new OTPEmail($otp));

                return response()->json([
                    'status' => 200,
                    'message' => 'Admin Logged In Successfully',
                    'otp' => $otp,
                    'is_verified' => 0,
                    'data' => $Admin,
                    'token' => $Admin->createToken("API TOKEN", ['otp'])->plainTextToken,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    private function getLoginStep($admin)
    {
        if ($admin->company->plan_id == 0) {
            return 'select_plan';
        } else {
            $import_excel_status  = $admin->company->import_excel_status;
            //import_excel_status => array('pending', 'imported', 'invitations', 'skipped'))
            if ($import_excel_status == 'pending') {
                return 'import_excel';
            } else if ($import_excel_status == 'imported') {
                return 'welcome';
            } else { // if  'invitations'or 'skipped'
                return 'completed';
            }
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

    public function verifyAdminEmail($otp)
    {
        try {
            $email = auth('sanctum')->user()->email;

            $current_otp = $this->OTPRepository->getOTPByEmail($email, 1);

            if ($otp != $current_otp->otp || $current_otp->attempts >= 5) {
                $this->OTPRepository->editOTP($email, $current_otp->otp, 1);
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid OTP',
                ], 400);
            }

            $Admin = $this->AdminRepository->verifyAdminEmail($email);
            $this->OTPRepository->delete($current_otp->id);

            return response()->json([
                'status' => 200,
                'message' => 'Admin Verified Successfully',
                'is_verified' => 1,
                'data' => $Admin,
                'token' => $Admin->createToken("API TOKEN", ['admin'])->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function forgetPassword($email)
    {
        $Admin = $this->AdminRepository->getAdminByEmail($email);
        if ($Admin) {
            $this->OTPRepository->deleteByEmail($email, 1);
            $otp = random_int(100000, 999999);
            $this->OTPRepository->store(1, $otp, $email, 0);
            Mail::to($email)->send(new ForgotPasswordOTPEmail($otp));
            return response()->json([
                'status' => 200,
                'otp' => $otp,
                'message' => 'OTP Sent Successfully',
                'token' => $Admin->createToken("API TOKEN", ['otp'])->plainTextToken,
            ], 200);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'Please Enter a valid Email',
            ], 422);
        }
    }

    public function updatePassword($password)
    {
        try {

            $id = auth('sanctum')->user()->id;
            $hash = Hash::make($password);

            $this->AdminRepository->updatePassword($id, $hash);

            return response()->json([
                'status' => 200,
                'message' => 'Password Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function resendOTP($type)
    {
        $email = auth('sanctum')->user()->email;
        $this->OTPRepository->deleteByEmail($email, 1);
        $otp = random_int(100000, 999999);
        $this->OTPRepository->store(1, $otp, $email, 0);

        if ($type == 'verify') {
            $mail = new OTPEmail($otp);
        } elseif ($type == 'forgot') {
            $mail = new ForgotPasswordOTPEmail($otp);
        } else {
            $mail = new OTPEmail($otp);
        }

        Mail::to($email)->send($mail);
        return response()->json([
            'status' => 200,
            'otp' => $otp,
            'message' => 'OTP Sent Successfully',
        ], 200);
    }
}
