<?php 

namespace App\Http\Requests\Dashboard;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CompanyEmployee;

class EquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:cms,id',
            'serial_number' => 'nullable|string|min:2|max:100|unique:equipments,serial_number,'.$this->route('equipment'),
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|min:2|max:100',
            'image' => 'nullable|image|max:5120',
            'in_use_by' => ['nullable', 'integer', 'exists:employees,id', new CompanyEmployee($this->company_id)],



        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 422,
            'message' => 'validation error',
            'errors' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}

 ?>