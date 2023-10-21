<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeExcelExportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file_extension'  => ['required', 'string', Rule::in(Employee::EXCEL_EXTENSION)],
            
            'file_columns'  => 'required|array',
            'file_columns.*'  => ['string', Rule::in(Employee::EXCEL_HEADING)],

            'ids' => 'array',
            'ids.*' => 'numeric|exists:employees,id',

            
            'from' => 'nullable|date_format:Y-m-d',
            'to' => 'nullable|date_format:Y-m-d',
            'department_id' => 'nullable|integer|exists:departments,id',
            'is_complete' => 'nullable|in:0,1',
            'sort' => 'nullable|string|in:newest,oldest',
        ];
    }
}
