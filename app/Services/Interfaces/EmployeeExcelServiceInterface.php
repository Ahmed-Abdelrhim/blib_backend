<?php
namespace App\Services\Interfaces;


interface EmployeeExcelServiceInterface
{
    public function importExcelReview($file);
    public function jsonExcelSave($employees_json);
    public function handleReviewStructure($data);
    // public function handleSaveStructure($data);
    public function handleReportsToID($company);
    public function save($data,int $company_id);
    public function sendInvitations($company,string $email_body);
    public function getTemplateInvitations($company);
    public function skipInvitations($company);
    
}