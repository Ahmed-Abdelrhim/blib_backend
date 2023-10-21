<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Employee;
use App\Repositories\Eloquent\CMSRepository;
use App\Rules\SameSubdomainEmailEmployee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeValidateAddRequest extends FormRequest
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
            'personal_information' => 'required',
            'personal_information.name' => 'required|string|min:2|max:50',

            // TO  HANDLE VALIDATION UNIQUE EMAIL
            // 'personal_information.email' => ['required', 'email','min:2', 'max:50', 'unique:employees', new SameSubdomainEmailEmployee], 
            'personal_information.email' => ['required', 'email','min:2', 'max:50', new SameSubdomainEmailEmployee, Rule::unique('employees', 'email')->ignore($this->getEmployeeId())],
            'personal_information.country_code' => 'required|string|max:5', 
            'personal_information.phone' => 'required|string|min:5|max:30',
            'personal_information.image' => 'nullable|image|max:5120',
            'personal_information.address' => 'nullable|string|min:2|max:100',
            'personal_information.bio' => 'nullable|string|min:2|max:100',
            'personal_information.description' => 'nullable|string|min:2|max:300',
            'personal_information.gender_id' => 'required|integer|exists:cms,id',
            'personal_information.military_status_id' => [$this->getMilitaryStatusRequiredValidation() | 'integer' | 'exists:cms,id'],
            'personal_information.country' => 'required|string|max:50',
            'personal_information.date_of_birth' => ['required', 'date', 'after_or_equal:' . date('Y') - 100 . '-01-01', 'before_or_equal:' . date('Y') - 16 . '-12-31', 'date_format:Y-m-d'],




            // 1.2 WORK INFORMATION
            'work_information' => 'sometimes',
            'work_information.title' => 'required_with:work_information|string|min:2|max:50',
            // 'work_information.title' => 'required|string|min:2|max:50',
            'work_information.department_id' => 'required_with:work_information|integer|exists:departments,id',


            'work_information.reports_to_id' => ['required_if:work_information.is_ceo,false','integer','exists:employees,id,deleted_at,NULL',Rule::notIn($this->getEmployeeId()),],

            'work_information.work_hours' => ['required_with:work_information','string', Rule::in(Employee::WORK_HOURS_ENUM)],

            'work_information.joined_at' => ['required_with:work_information', 'date', 'after_or_equal:' . date('Y') - 100 . '-01-01', 'before_or_equal:today', 'date_format:Y-m-d'],
            'work_information.salary' => 'nullable|integer|min:100',  
            'work_information.currency' => 'required_with:work_information|string|max:5',
            'work_information.is_important' => 'required_with:work_information|in:0,1',

            'work_information.is_ceo' => 'required_with:work_information|boolean',


            // 1.3 EQUIPMENTS



            // 1.4 DOCUMENTS



            // 1.5 VACATIONS
            'vacations' => 'sometimes',
            'vacations.vacation_activate_id' => 'required_with:vacations|integer|exists:cms,id',
            'vacations.vacation_expire_carry_id' => 'required_with:vacations|integer|exists:cms,id',
            // 'vacations.vacation_first_approval_id' => 'required|integer|exists:employees,id,deleted_at,NULL',
             'vacations.vacation_first_approval_id' => [
                'required_with:vacations',
                'integer',
                'exists:employees,id,deleted_at,NULL',
                function ($attribute, $value, $fail) {
                    // Get the value of vacation_second_approval_id
                    $secondApprovalId = $this->input('vacations.vacation_second_approval_id');

                    // Check if vacation_first_approval_id is the same as vacation_second_approval_id
                    if ($value === $secondApprovalId) {
                        $fail('The first approval and second approval must be different persons.');
                    }
                },
            ],
        
            'vacations.vacation_second_approval_id' => 'nullable|integer|exists:employees,id,deleted_at,NULL',
            'vacations.vacation_annual_days' => 'required_with:vacations|integer|min:0|max:365',
            'vacations.vacation_carry_days' => 'required_with:vacations|integer|min:0|lt:vacation_annual_days',


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
            'work_information.reports_to_id.not_in' => 'The reporting manager cannot be the same as the employee.',
        ];
    }



    public function getEmployeeId()
    {
        return $this->route('employee'); // Assumes you pass the employee ID as a route parameter.
    }
}
