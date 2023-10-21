<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'equipments';

    protected $hidden = ['created_at', 'updated_at'];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function category()
    {
        return $this->belongsTo(CMS::class);
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'in_use_by');
    }


    public function assignees()
    {
        return $this->hasMany(EmployeeEquipment::class);
    }
}
