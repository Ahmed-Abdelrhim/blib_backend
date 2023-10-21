<?php

namespace App\Imports;

use App\Rules\SameSubdomainEmailEmployee;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Str;



class EmployeeImport implements WithHeadingRow, SkipsEmptyRows, WithValidation, ToCollection,  SkipsOnFailure
{
    private $dataCollection;
    private $customValidation;

    public function __construct()
    {
        $this->dataCollection = collect([]);
    }

    public function collection(Collection $rows)
    {
        $this->dataCollection =  $rows->map(function ($row) {
            return collect([
                // 'employee_name' => $row['employee_name'],
                'employee_name' => preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['employee_name']),
                'email' => Str::lower($row['email']),
                'title' => $row['title'],
                'department' => $row['department'],
                'salary' => $row['salary'] ?? null,
                'report_to_email' => (!empty($row['report_to_email'])) ? Str::lower($row['report_to_email']) : null,
                'description' => $row['description'] ?? null,
            ]);
        });
    }
    public function getCollection(): collection
    {
        return $this->dataCollection;
    }


    public function rules(): array
    {
        return [
            'employee_name' => 'required',
            '*.employee_name' => ['required', 'max:50'],


            'email' => 'required',
            '*.email' => ['required', 'email', 'max:50', 'unique:employees', new SameSubdomainEmailEmployee],


            'title' => 'required',
            '*.title' => 'required|max:50',


            'department' => 'required',
            '*.department' => 'required|max:50',


            'salary' => 'required',
            '*.salary' => 'nullable|not_in:0|numeric',


            'report_to_email' => 'required',
            '*.report_to_email' => ['nullable', 'email', 'max:50', new SameSubdomainEmailEmployee],



            'description' => 'required',
            '*.description' => 'nullable|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'employee_name.required' => 'required employee name.',
            'employee_name.max' =>  'employee name exceeds 50 characters.',

            'email.required' => 'required employee email.',
            'email.max' =>  'employee email exceeds 50 characters.',
            'email.email' => 'incorrect email format',
            'email.unique' => 'employee emails already exist in database',


            'title.required' => 'required employee title.',
            'title.max' =>  'employee title exceeds 50 characters.',


            'department.required' => 'required employee department.',
            'department.max' =>  'employee department exceeds 50 characters.',

            'report_to_email.email' => 'incorrect report to email format',
            'report_to_email.max' =>  'employee report to email exceeds 50 characters.',

            'description.max' =>  'employee description exceeds 255 characters.',

        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        $data = collect($failures)->toArray();
        $customValidation = [];
        foreach ($data as $row) {
            $key = explode('. ', $row[0])[1];
            if (isset($customValidation[$key]))
                $customValidation[$key]++;
            else
                $customValidation[$key] = 1;
        }
        foreach ($customValidation as $k => $v) {
            $this->customValidation[] = ['There are ('. $v . ') ' .$k];
        }
    }

    public function getCustomFailures()
    {
        return $this->customValidation;
    }
}
