<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 
use Symfony\Component\HttpFoundation\Response;

class EmployeeUpdateDataRequest extends FormRequest
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
        return           
        [
            'country_code' => 'required|string|max:5',
            'phone' => 'required|string|max:15',
            'profile_image' => 'image|max:20480',
            'date_of_birth' => [
                'required',
                'date',
                // 'date_format:Y-m-d',
                'after_or_equal:' . date('Y') - 100 . '-01-01',
                'before_or_equal:' . date('Y') - 16 . '-12-31'
            ],
        ];
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
