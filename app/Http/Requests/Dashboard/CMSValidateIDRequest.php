<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CMSValidateIDRequest extends FormRequest
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
            'id' => 'required|exists:cms,id|numeric',
        ];
    }

    protected function prepareForValidation(): void
    {
        $id = $this->route('id') ?? $id = $this->route('cm'); //or whatever it is named in the route
        $this->merge(['id' => $id]);
    }
}
