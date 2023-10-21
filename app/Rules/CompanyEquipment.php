<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Equipment;

class CompanyEquipment implements Rule
{

    public function passes($attribute, $value)
    {

        return Equipment::where('id', $value)
            ->where('company_id', auth('sanctum')->user()->company->id)
            ->exists();
    }

    public function message()
    {
        return 'The selected equipment does not belong to the company.';
    }
}
