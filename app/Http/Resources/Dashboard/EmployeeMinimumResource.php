<?php

namespace App\Http\Resources\Dashboard;

use App\Models\PriceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeMinimumResource extends JsonResource
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
            'name' => $this->name,
            'title' => $this->title,
            'email' => $this->email,
            'department' => $this->department->title ?? null,
            'reports_to_name' => $this->reports_to_minimum->name ?? null,
            'reports_to' => $this->reports_to_minimum ?? null,
            // 'is_complete' => $this->is_personal_information_complete && $this->is_work_information_complete && $this->is_vacations_complete ? 1 : 0,
            'is_complete' => $this->is_personal_information_complete ,
            'image' => $this->image,
        ];

        
    }
}
