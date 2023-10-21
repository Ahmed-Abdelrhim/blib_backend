<?php

namespace App\Traits;

trait ExcelExtraValidationTrait
{

    public function isPackageTotalValidation(int $data_count, int $package_max_count)
    {
        if ($data_count > $package_max_count) {
            return [
                'status' => false,
                'errors' =>  ['The bundle has been exceeded by ('.$data_count - $package_max_count .') additional rows'],
                'message' => 'error',

            ];
        }
        return [
            'status' => true,
            'message' => 'success',
        ];
    }



    public function isUniqueEmailValidation(int $data_count, int $data_unique_count)
    {
        if ($data_count != $data_unique_count) {
            return [
                'status' => false,
                'errors' =>  ['There are ('.$data_count - $data_unique_count .') duplicate employee emails'],
                'message' => 'error',

            ];
        }
        return [
            'status' => true,
            'message' => 'success',
        ];
    }
}
