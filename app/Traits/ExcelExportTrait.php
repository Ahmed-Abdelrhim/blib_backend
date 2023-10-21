<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Str;

trait ExcelExportTrait
{

    public function excelExport($export_class, array $headings, string $extension, Collection $file_data, string $file_name)
    {
        $file_extension_type = $this->getFileExtensionType($extension);
        $file_name = $this->handleFileName($file_name,$file_extension_type);
        ob_end_clean(); //for generating excel XLSX
        ob_start(); //for generating excel XLSX
        return (new $export_class($headings, $file_data))->download($file_name, $file_extension_type);
    }


    private function getFileExtensionType(string $extension)
    {
        switch ($extension) {
            case 'CSV':
                return  Excel::CSV;
            default:
                return Excel::XLSX;
        }
    }

    private function handleFileName(string $file_name, string $file_extension_type,)
    {
        $file_name = date('Y-m-d') . '-' . $file_name . '.' . Str::lower($file_extension_type);
        $file_name = Str::replace(' ', '-', $file_name);
        return $file_name;
    }
}
