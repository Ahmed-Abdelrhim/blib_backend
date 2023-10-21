<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const WORK_HOURS_ENUM = [
        'Full Time',
        'Part Time',
        'Fully Remotely',
        'Part Time Remotely',
        'Casual',
        'Fixed Term Contract',
        'Apprenticeship',
        'Internship'
    ];


    const EXCEL_HEADING = [
        'Employee Name',
        'Job Title',
        'Department',
        'Report To',
        'Email Address',
        'Mobile Number',
        'Date of Birth',
        'Gender',
        'Country',
        'Address',
        'Military Status',
        'Job Type',
        'About',
        'Salary',
        'Joined Year',
        'Bio',
    ];

    const EXCEL_EXTENSION = [
        'Excel Sheet',
        'CSV',
    ];


    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'title',
        'password',
        'phone',
        'country_code',
        'date_of_birth',
        'department_id',
        'reports_to_id',
        'temp_reports_to_email',
        'role_id',
        'image',
        'banner',
        'description',
        'bio',
        'gender_id',
        'military_status_id',
        'country',
        'address',
        'work_hours',
        'salary',
        'currency',
        'is_first_time',
        'is_important',
        'is_personal_information_complete',
        'is_work_information_complete',
        'is_vacations_complete',
        'joined_at',
        'vacation_activate_at',
        'vacation_expire_carry_at',
        'vacation_first_approval_id',
        'vacation_second_approval_id',
        'vacation_annual_days',
        'vacation_carry_days',
        'deleted_by_id',
    ];

    protected $cast = [
        // 'department' => 'object',
        'work_hours' => 'string'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',

    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // public function getDepartmentTitleAttribute()
    // {
    //     return $this->department()->title;
    // }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function reports_to()
    {
        return $this->belongsTo(Employee::class, 'reports_to_id');
    }

    public function gender()
    {
        return $this->belongsTo(CMS::class, 'gender_id');
    }

    public function military_status()
    {
        return $this->belongsTo(CMS::class, 'military_status_id');
    }

    public function reports_to_minimum()
    {
        return $this->reports_to()
            ->select('id', 'name', 'email', 'title', 'image');
    }

    public function deleted_by()
    {
        return $this->belongsTo(Admin::class, 'deleted_by_id');
    }
}
