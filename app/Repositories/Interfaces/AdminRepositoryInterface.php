<?php
namespace App\Repositories\Interfaces;

interface AdminRepositoryInterface
{
    public function store($company_id, $email, $hash, $name = '');
    public function getAdminByEmail($email);
    public function verifyAdminEmail($email);
    public function updatePassword($id, $hash);
    public function getAdminByEmailWithCompany($email);
}