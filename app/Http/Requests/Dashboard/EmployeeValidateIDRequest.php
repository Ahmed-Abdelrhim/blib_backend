<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidateIDRequest extends FormRequest
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
    public function rules()
    {

        return $this->validation;

    }

    protected function prepareForValidation(): void
    {
        $id = $this->route('id') ?? $id = $this->route('employee'); //or whatever it is named in the route.
        $this->merge(['id' => $id]);

        str_contains(url()->current(), '/restore') ?
        $this->validation = ['id' => 'required|exists:employees,id|numeric']: // validate restore id.
        $this->validation = ['id' => 'required|exists:employees,id,deleted_at,NULL|numeric']; // validate delete id.

    }
}
