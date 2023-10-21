<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * AdminRepository constructor.
     *
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function store($company_id, $email, $hash, $name = '')
    {
        $admin = $this->model->create([
            'name' => $name,
            'company_id' => $company_id,
            'email' => $email,
            'password' => $hash,
        ]);

        return $admin;
    }

    public function getAdminByEmail($email)
    {
        $Employee = $this->model->where('email', $email)->first();
        return $Employee;
    }

    public function getAdminByEmailWithCompany($email)
    {
        $Employee = $this->model->with('company')->where('email', $email)->first();
        return $Employee;
    }

    public function verifyAdminEmail($email){
        $Employee = $this->model->where('email', $email)->first();
        $Employee->markEmailAsVerified();
        return $Employee;
    }

    public function updatePassword($id, $hash)
    {
        $Employee = $this->model->whereId($id)->update([
            'password' => $hash,
        ]);
        return $Employee;
    }


    public function findByCompanyId($companyId)
    {
        return $this->model->where('company_id', $companyId)->first();
    }


    public function delete($adminId)
    {
        return $this->model->where('id', $adminId)->delete();
    }
}
