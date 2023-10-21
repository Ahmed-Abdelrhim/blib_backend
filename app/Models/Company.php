<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';


    protected $fillable = [
        'name',
        'domain',
        'logo',
        'industry_id',
        'plan_id',
        'is_imported',
        'import_excel_status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }


    public function ceo()
    {
        return $this->belongsTo(Employee::class, 'ceo_id');
    }
}
