<?php 

namespace App\Http\Requests\Dashboard;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CompanyEmployee;
use App\Rules\CompanyEquipment;
use App\Rules\EquipmentAvailability;

class TakeOffEquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'employee_equipment_id' => ['required', 'integer', 'exists:employee_equipment,id'],
            'returned_at' => ['date', 'date_format:Y-m-d'],
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