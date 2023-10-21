<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEquipment extends Model
{

    protected $guarded = ['id'];
    protected $table = 'employee_equipment';

    protected $hidden = ['created_at', 'updated_at'];


    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }


}
