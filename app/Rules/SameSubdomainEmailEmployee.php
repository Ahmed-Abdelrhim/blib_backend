<?php

namespace App\Rules;

use App\Models\Employee;
use App\Repositories\Eloquent\EmployeeRepository;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
 
 
class SameSubdomainEmailEmployee implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $company =  auth('sanctum')->user()->company;

         if (!Str::endsWith($value, $company->domain)) {
            $fail(':attribute incorrect email subdomain.');
        }
    }

}
