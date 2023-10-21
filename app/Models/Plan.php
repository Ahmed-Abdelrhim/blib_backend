<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'min_employees', 
        'max_employees', 
        'description',
        'is_free'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
