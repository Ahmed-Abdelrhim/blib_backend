<?php

namespace App\Services;

use App\Imports\EmployeeImport;
use App\Jobs\SendMailTemplateJob;
use App\Mail\InvitationEmail;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use App\Services\Interfaces\EmployeeExcelServiceInterface;
use App\Traits\ExcelExtraValidationTrait;
use App\Traits\ResponseTrait;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeExcelService implements EmployeeExcelServiceInterface
{
    use ResponseTrait, ExcelExtraValidationTrait;

    private $employeeRepository;
    private $departmentRepository;
    private $planRepository;
    private $companyRepository;


    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        PlanRepositoryInterface $planRepository,
        DepartmentRepositoryInterface $departmentRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->departmentRepository = $departmentRepository;
        $this->planRepository = $planRepository;
        $this->companyRepository = $companyRepository;
    }


    /**
     * 
     * Validate, Import and Group By Department
     * 
     * @param file $file
     * @return json
     */
    public function importExcelReview($file)
    {
        $company = auth('sanctum')->user()->company;

        // 1. Validate and Get Data From File.
        $result = $this->validateGetFileData($file, $company);

        if (!$result['status'])
            return $this->error422($result['errors']);


        // 2. Handle Review Structure.
        $data_restructured = $this->handleReviewStructure($result['data']);

        return $this->success200($data_restructured);
    }


    /**
     * Employees Json Excel Save
     * 
     * @param json $employees_json
     * @return json
     */
    public function jsonExcelSave($employees_json)
    {
        $company = auth('sanctum')->user()->company;

        // 1. Handle Save Structure.
        // $data = $this->handleSaveStructure($employees_json);

        // 2. Add Department, Titles, Employees to Database.
        $result = $this->save($employees_json, $company->id);

        if (!$result) {
            return $this->error500([$result]);
        }

        // 3. Update Employees Reports to ID.
        $this->handleReportsToID($company);

        //4. Update Company imported flag to true.
        $this->companyRepository->update($company->id, ['is_imported' => 1]);
        $this->companyRepository->update($company->id, ['import_excel_status' => 'imported']);

        return $this->success201();
    }


    public function getTemplateInvitations($company)
    {
        $data = [
            'employees_count' =>  $this->employeeRepository->getEmailsInvitations($company->domain)->count(),
            'html' => view('emails.template_invitation')->render()
        ];
        return $this->success200($data);
    }


    public function skipInvitations($company)
    {
        $this->companyRepository->update($company->id, ['import_excel_status' => 'skipped']);
    }
    

    /**
     * Send Emails to Company with Invitations and Temporary Password
     * 
     * @param json $employees_json
     * @return json
     */
    public function sendInvitations($company, string $email_body)
    {
        $employees = $this->employeeRepository->getEmailsInvitations($company->domain);
        $email_body = Str::replace('\n', '', $email_body);

        foreach ($employees as $employee) {
            $job = new SendMailTemplateJob($employee, $email_body, $this->employeeRepository);
            dispatch($job);
        }

        $this->companyRepository->update($company->id, ['import_excel_status' => 'invitations']);
    }



    public function validateGetFileData($file, $company)
    {
        $validation_array_all = [];

        $import = new EmployeeImport;
        Excel::import($import, $file);

        if ($import->getCustomFailures()) {
            $validation_array_all =  $import->getCustomFailures();
        }

        $data = $import->getCollection();

        $result = $this->handleRemainingValidation($data, $company);

        if (!$result['status']) {
            $validation_array_all =  $result['errors'];
        }




         // Check if any employee reports to himself
        $selfReportCount = $data->filter(function ($row) {
            return $row['email'] === $row['report_to_email'];
        })->count();

        if ($selfReportCount > 0) {
            $validation_array_all[] = ['Employee cannot report to himself.'];
        }


        //Check if there is more than one row with a null value in 'report_to_email'
        $nullReportToEmailCount = $data->where('report_to_email', null)->count();
        if ($nullReportToEmailCount > 1) {
            $validation_array_all[] = ['Only CEO can have a null value in Report To Email field.'];
        }


        if (!empty($validation_array_all)) {
            return [
                'status' => false,
                'errors' => $validation_array_all
            ];
        }


        return [
            'status' => true,
            'data' => $data,
        ];
    }




    public function handleRemainingValidation($data_collection, $company)
    {
        $validation_array_all = [];

        $validation_result_email = $this->isUniqueEmailValidation($data_collection->count(), $data_collection->unique('email')->count());
        if (!$validation_result_email['status']) {
            // return $validation_result_email;
            array_push($validation_array_all, $validation_result_email['errors']);
        }

        $package_max_employees =  $this->planRepository->get($company->plan_id)->max_employees ?? 0;
        $validation_result_total = $this->isPackageTotalValidation($data_collection->count(), $package_max_employees);
        if (!$validation_result_total['status']) {
            // return $validation_result_total;
            array_push($validation_array_all, $validation_result_total['errors']);
        }

        if (!empty($validation_array_all)) {
            return [
                'status' => false,
                'errors' =>  $validation_array_all,
                'message' => 'error',

            ];
        }
        return [
            'status' => true,
            'message' => 'success',
        ];
    }


    public function handleReviewStructure($data)
    {
        $data = $data->map(function ($row) use ($data) {
            if (is_null($row['report_to_email'])) {
                $name = null;
            } else {
                if ($result = $data->where('email', $row['report_to_email'])->first()) {
                    $name = $result['employee_name'];
                } else {
                    $name = $row['report_to_email'];
                }
            }
            return $row->put('reports_to_name', $name);
        });

        return $data->groupBy('department');
    }



    // public function handleSaveStructure($data)
    // {
    //     $data = collect($data);
    //     return $data->map(function ($row) {
    //         return collect($row)->groupBy('title');
    //     });
    // }

    // public function save($data, $company_id): bool
    public function save($data, $company_id)
    {
        try {
            DB::transaction(function () use ($data, $company_id) {
                foreach ($data as $department => $employees) {
                    $department = $this->departmentRepository->firstOrCreate([
                        'title' => $department,
                        'company_id' => $company_id
                    ]);
                    foreach ($employees as $employee) {
                        $this->employeeRepository->firstOrCreate([
                            'company_id' => $company_id,
                            'department_id' => $department->id,
                            // 'name' => $employee['employee_name'],
                            'name' => preg_replace('/[^A-Za-z0-9\-]/', ' ', $employee['employee_name']),
                            'email' => $employee['email'],
                            'title' => $employee['title'],
                            'description' => $employee['description'] ?? null,
                            'salary' => $employee['salary'] ?? null,
                            'temp_reports_to_email' => $employee['report_to_email'] ?? null,
                        ]);
                    }
                }
            });
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function handleReportsToID($company)
    {
        $data_all = $this->employeeRepository->getAllWhereDomain($company->domain);
        $data_structured = $data_all->whereNotNull('temp_reports_to_email')->groupBy('temp_reports_to_email');

        foreach ($data_structured as $email_of_head => $employees) {
            if ($head = $data_all->where('email', $email_of_head)->first()) {
                $this->employeeRepository->updateWhereIn(
                    $employees->pluck('id')->toArray(),
                    [
                        'reports_to_id' => $head->id,
                        'temp_reports_to_email' => null
                    ]
                );
            }
        }
    }
}
