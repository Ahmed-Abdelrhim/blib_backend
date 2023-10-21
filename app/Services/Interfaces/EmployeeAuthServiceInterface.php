<?php
namespace App\Services\Interfaces;

interface EmployeeAuthServiceInterface
{
   public function login($credentials);
   public function logout($request);
   public function updatePassword($password);
   public function forgetPassword($email);
   public function verifyOTP($otp);
   public function resendOTP();
}