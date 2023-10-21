<?php
namespace App\Repositories\Interfaces;

interface OTPRepositoryInterface
{
    public function store($type, $otp, $email, $attempts);
    public function getOTPByEmail($email,$type);
    public function editOTP($email, $otp, $type);
    public function delete($id);
    public function deleteByEmail($email,$type);
}