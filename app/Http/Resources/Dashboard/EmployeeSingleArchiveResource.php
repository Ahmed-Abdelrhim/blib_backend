<?php

namespace App\Http\Resources\Dashboard;

use App\Models\PriceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeSingleArchiveResource extends JsonResource
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
            'country' => $this->country,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'date_of_birth' => $this->date_of_birth,
            'department' => new DepartmentSelectResource($this->department) ?? null,
            'reports_to' => $this->reports_to_minimum ?? null,
            'description' => $this->description,
            'gender' => $this->gender,
            'military_status' => $this->military_status,
            'address' => $this->address,
            'salary' => $this->salary,
            'currency' => $this->currency,
            'work_hours' => $this->work_hours,
            'joined_at' => $this->joined_at,
         ];

        
    }
}
