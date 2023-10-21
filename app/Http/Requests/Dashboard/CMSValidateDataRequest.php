<?php

namespace App\Http\Requests\Dashboard;

use App\Models\CMS;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSValidateDataRequest extends FormRequest
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
        $id = $this->route('id') ?? $id = $this->route('cms'); //or whatever it is named in the route
        $this->merge(['id' => $id]);

        $common_validation = $this->getCommonValidation();
        $extra_validation = $this->handleRemainingValidation($id);
        $this->validation = array_merge($common_validation, $extra_validation);
    }


    private function getCommonValidation()
    {
        if (($this->type == 'vacation_activate') || ($this->type == 'vacation_expire_carry_days')) {
            return [
                'title' => 'required|string|max:50',
                'value' => 'required|integer|min:0,max:12',
                'type'  => ['required','string', Rule::in(CMS::TYPES)],

            ];
        } else {
            return [
                'title' => 'required|string|max:50',
                'type'  => ['required','string', Rule::in(CMS::TYPES)],
            ];
        }
    }


    private function handleRemainingValidation($id)
    {
        if ($id) { // Update Request Extra Validation
            return  ['id' => 'required|exists:cms,id|integer'];
        } else {
            return [];
        }
    }
}
