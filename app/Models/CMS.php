<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    use HasFactory;

    const TYPES = ['gender', 'military_status', 'equipment_types','vacation_activate','vacation_expire_carry_days','paper_request_to'];


    protected $table = 'cms';


    protected $fillable = [
        'company_id',
        'title',
        'type',
        'value',
    ];

    protected $hidden = ['created_at', 'updated_at'];

}
