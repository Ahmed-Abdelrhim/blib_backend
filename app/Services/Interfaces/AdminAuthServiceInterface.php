<?php
namespace App\Services\Interfaces;

interface AdminAuthServiceInterface
{
   public function login($credentials);
   public function logout($request);
   public function verifyAdminEmail($otp);
   public function forgetPassword($email);
   public function updatePassword($password);
   public function resendOTP($type);
}