<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Equipment;

class EquipmentAvailability implements Rule
{

    public function passes($attribute, $value)
    {

        return Equipment::where('id', $value)
            ->whereNull('in_use_by')
            ->exists();
    }

    public function message()
    {
        return 'The selected equipment is used by another employee.';
    }
}
