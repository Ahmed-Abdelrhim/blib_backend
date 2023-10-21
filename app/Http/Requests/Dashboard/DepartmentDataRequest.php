<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentDataRequest extends FormRequest
{
    private $validation;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return $this->validation;
    }

    protected function prepareForValidation(): void
    {
        $id = null;

        $extra_validation = [];
        $id = $this->route('id') ?? $id = $this->route('department'); //or whatever it is named in the route
        $this->merge(['id' => $id]);

        $common_validation = $this->getCommonValidation();
        $extra_validation = $this->handleRemainingValidation($id);
        $this->validation = array_merge($common_validation, $extra_validation);
    }


    private function getCommonValidation()
    {
        return [
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:300',
        ];
    }

    private function handleRemainingValidation($id)
    {
        if ($id) { // Update Request Extra Validation
            return  [
                'id' => 'required|exists:departments,id|integer',
                'added_employee_ids' => 'nullable|array',
                'added_employee_ids.*' => 'numeric|exists:employees,id,deleted_at,NULL',

                'deleted_employee_ids' => 'nullable|array',
                'deleted_employee_ids.*' => 'numeric|exists:employees,id,deleted_at,NULL,department_id,' . $id,

            ];
        } else { // Add Request Extra Validation
            return [
                'employee_ids' => 'nullable|array',
                'employee_ids.*' => 'numeric|exists:employees,id,deleted_at,NULL',
            ];
        }
    }
}
