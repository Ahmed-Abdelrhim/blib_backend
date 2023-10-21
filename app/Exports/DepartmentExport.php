<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{

    use Exportable;

    private $headings_array;
    private $data;

    public function __construct($headings_array, $data)
    {
        $this->headings_array = $headings_array;
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }


    public function map($row): array
    {
        $array_data = [];
        in_array('Department Name', $this->headings_array) ? array_push($array_data, $row->title)  : null;
        in_array('Employees No', $this->headings_array) ? array_push($array_data, $row->employees_count ?? 0) : null;
        in_array('Description', $this->headings_array) ? array_push($array_data, $row->description) : null;
        return $array_data;
    }

    public function headings(): array
    {
        return $this->headings_array;
    }
}
