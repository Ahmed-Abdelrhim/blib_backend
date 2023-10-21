<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Employee;

class CompanyEmployee implements Rule
{
    
    public function passes($attribute, $value)
    {

        return Employee::where('id', $value)
            ->where('company_id', auth('sanctum')->user()->company->id)
            ->exists();
    }

    public function message()
    {
        return 'The selected employee does not belong to the company.';
    }
}
