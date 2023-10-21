<?php 

namespace App\Http\Requests\Dashboard;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CompanyEmployee;
use App\Rules\CompanyEquipment;
use App\Rules\EquipmentAvailability;

class AssignEquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'equipment_id' => ['required', 'integer', 'exists:equipments,id', new CompanyEquipment($this->company_id), new EquipmentAvailability($this->company_id)],
            'employee_id' => ['required', 'integer', 'exists:employees,id', new CompanyEmployee($this->company_id)],
            'taken_at' => ['date', 'date_format:Y-m-d'],
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