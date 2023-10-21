<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
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


        // dd($row);
        $array_data = [];
        in_array('Employee Name', $this->headings_array) ? array_push($array_data, $row->name)  : null;
        in_array('Job Title', $this->headings_array)  ? array_push($array_data, $row->title)  : null;
        in_array('Department', $this->headings_array) ? array_push($array_data, $row->department->title ?? ' ')  : null;
        in_array('Report To', $this->headings_array) ? array_push($array_data, $row->reports_to_minimum->name ?? ' ')  : null;
        in_array('Email Address', $this->headings_array) ? array_push($array_data, $row->email ?? ' ')  : null;
        in_array('Mobile Number', $this->headings_array) ? array_push($array_data, $row->country_code . $row->phone ?? ' ')  : null;
        // in_array('Date of Birth', $this->headings_array) ? array_push($array_data, $row->date_of_birth)  : null;
        // in_array('Date of Birth', $this->headings_array) ? array_push($array_data, date('d/m/Y', strtotime($row->date_of_birth) ?? ' '))  : null;
        if (in_array('Date of Birth', $this->headings_array)) {
            is_null($row->date_of_birth) ? array_push($array_data, ' ') : array_push($array_data, date('d/m/Y', strtotime($row->date_of_birth)));
        } else {
            null;
        }
        in_array('Gender', $this->headings_array) ? array_push($array_data, $row->gender->title ?? ' ')  : null;
        in_array('Country', $this->headings_array) ? array_push($array_data, $row->country ?? ' ')  : null;
        in_array('Address', $this->headings_array) ? array_push($array_data, $row->address ?? ' ')  : null;
        in_array('Military Status', $this->headings_array) ? array_push($array_data, $row->military_status->title ?? ' ')  : null;
        in_array('Job Type', $this->headings_array) ? array_push($array_data, $row->work_hours ?? ' ')  : null;
        in_array('About', $this->headings_array) ? array_push($array_data, $row->description ?? ' ')  : null;
        in_array('Salary', $this->headings_array) ? array_push($array_data, $row->salary ?? ' ')  : null;
        // in_array('Joined Year', $this->headings_array) ? array_push($array_data, $row->joined_at)  : null;
        // in_array('Joined Year', $this->headings_array) ? array_push($array_data, date('d/m/Y', strtotime($row->joined_at)))  : null;
        if (in_array('Joined Year', $this->headings_array)) {
            is_null($row->joined_at) ? array_push($array_data, ' ') : array_push($array_data, date('d/m/Y', strtotime($row->joined_at)));
        } else {
            null;
        }
        in_array('Bio', $this->headings_array) ? array_push($array_data, $row->bio ?? ' ')  : null;
        return $array_data;



        // $fieldlabelCollection=collect([

        //     [
        //         'label'=>"Employee name",
        //         'column'=>'name'
        //         'column'=>'de'
        //     ]
        // ]);

        // $columns=$fieldlabelCollection->whereIn('label',$this->headings_array)->pluck('column')->toArray();
        // foreach($columns as $column){
        //     if($column ==''){

        //     }
        //     $array_data[]=$row->{$column}

    }



    // return $array_data;
    // }

    public function headings(): array
    {
        return $this->headings_array;
    }
}
