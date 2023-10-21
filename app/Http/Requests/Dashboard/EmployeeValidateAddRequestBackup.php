<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Employee;
use App\Repositories\Eloquent\CMSRepository;
use App\Rules\SameSubdomainEmailEmployee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeValidateAddRequestBackup extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            // 1.1 PERSONAL INFORMATION
            'name' => 'required|string|min:2|max:50',
            'email' => ['required', 'email','min:2', 'max:50', 'unique:employees', new SameSubdomainEmailEmployee],
            'country_code' => 'required|string|max:5', 
            'phone' => 'required|string|min:5|max:30',
            'image' => 'nullable|image|max:5120',
            'address' => 'nullable|string|min:2|max:100',
            'bio' => 'nullable|string|min:2|max:100',
            'description' => 'nullable|string|min:2|max:300',
            'gender_id' => 'required|integer|exists:cms,id',
            'military_status_id' => [$this->getMilitaryStatusRequiredValidation() | 'integer' | 'exists:cms,id'],
            'country' => 'required|string|max:50',
            'date_of_birth' => ['required', 'date', 'after_or_equal:' . date('Y') - 100 . '-01-01', 'before_or_equal:' . date('Y') - 16 . '-12-31'],


            // 1.2 WORK INFORMATION
            'title' => 'required|string|min:2|max:50',
            'department_id' => 'required|integer|exists:departments,id',
            'reports_to_id' => 'nullable|integer|exists:employees,id,deleted_at,NULL',
            'work_hours' => ['required','string', Rule::in(Employee::WORK_HOURS_ENUM)],
            'joined_at' => ['required', 'date', 'after_or_equal:' . date('Y') - 100 . '-01-01', 'before_or_equal:today'],
            'salary' => 'nullable|integer|min:100',  
            'currency' => 'required|string|max:5',
            'is_important' => 'required|in:0,1',

            // 1.3 EQUIPMENTS



            // 1.4 DOCUMENTS



            // 1.5 VACATIONS
            'vacation_activate_id' => 'required|integer|exists:cms,id',
            'vacation_expire_carry_id' => 'required|integer|exists:cms,id',
            'vacation_first_approval_id' => 'required|integer|exists:employees,id,deleted_at,NULL',
            'vacation_second_approval_id' => 'nullable|integer|exists:employees,id,deleted_at,NULL',
            'vacation_annual_days' => 'required|integer|min:0|max:365',
            'vacation_carry_days' => 'required|integer|min:0|lt:vacation_annual_days',


        ];
    }

    private function getMilitaryStatusRequiredValidation()
    {
        if ($this->gender == 'male') {
            return 'required';
        }
        return 'nullable';
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date_of_birth.before_or_equal' => 'The date of birth must be greater than 16 years old',
            'date_of_birth.after_or_equal' => 'The date of birth must be less than 100 years old',
        ];
    }
}
