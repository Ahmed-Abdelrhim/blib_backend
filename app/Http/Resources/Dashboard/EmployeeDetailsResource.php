<?php

namespace App\Http\Resources\Dashboard;

use App\Models\PriceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'image' => $this->image,       
            'name' => $this->name,
            'email' => $this->email,
            'title' => $this->title,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'date_of_birth' => $this->date_of_birth,
            'department' => new DepartmentSelectResource($this->department) ?? null,
            'reports_to' => $this->reports_to_minimum ?? null,
            'description' => $this->description,
            'bio' => $this->bio,
            'gender' => $this->gender,
            'military_status' => $this->military_status,
            'address' => $this->address,
            'salary' => $this->salary,
            'work_hours' => $this->work_hours,
            'joined_at' => $this->joined_at,
            // 'is_complete' => $this->is_personal_information_complete && $this->is_work_information_complete && $this->is_vacations_complete ? 1 : 0,
            'is_complete' => $this->is_personal_information_complete ,
            'is_important' => $this->is_important,

            
         ];

        
    }
}
