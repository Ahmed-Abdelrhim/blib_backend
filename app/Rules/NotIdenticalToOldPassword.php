<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class NotIdenticalToOldPassword implements Rule
{
    public function passes($attribute, $value)
    {
        // Retrieve the old password from the database for the currently authenticated user
        $oldPassword = auth('sanctum')->user()->password;

        // Compare the new password to the old password
        return !Hash::check($value, $oldPassword);
    }

    public function message()
    {
        return 'The :attribute must not be identical to the old password.';
    }
}
