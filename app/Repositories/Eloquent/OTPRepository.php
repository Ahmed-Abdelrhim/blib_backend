<?php

namespace App\Repositories\Eloquent;

use App\Models\OTP;
use App\Repositories\Interfaces\OTPRepositoryInterface;

class OTPRepository implements OTPRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * OTPRepository constructor.
     *
     * @param OTP $model
     */
    public function __construct(OTP $model)
    {
        $this->model = $model;
    }

    public function store($type, $otp, $email, $attempts){
        $otp = $this->model->create([
            'type' => $type,
            'otp'  => $otp,
            'email' => $email,
            'attempts' => $attempts 
        ]);

        return $otp;
    }

    public function getOTPByEmail($email,$type)
    {
        $otp = $this->model->where(['email' => $email, 'type' => $type])->first();
        return $otp;
    }

    public function editOTP($email, $otp, $type){
        $current_otp = $this->model->where(['email' => $email, 'type' => $type])->first();
        $current_otp->update(['otp' => $otp, 'attempts' => $current_otp->attempts + 1]);
        return $current_otp;
    }

    public function delete($id){
        $otp = $this->model->whereId($id)->delete();
        return $otp;
    }

    public function deleteByEmail($email,$type){
        $otp = $this->model->where(['email' => $email, 'type' => $type])->delete();
        return $otp;
    }
}
