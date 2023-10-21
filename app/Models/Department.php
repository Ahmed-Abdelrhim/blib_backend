<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    const EXCEL_HEADING = ['Department Name', 'Employees No', 'Description'];

    const EXCEL_EXTENSION = ['Excel Sheet', 'CSV'];

    protected $fillable = [
        'company_id',
        'title',
        'description'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employees_minimum()
    {
        return $this->employees()
            ->select('id', 'department_id', 'name', 'image',  'title', 'reports_to_id', 'email');
    }
}
