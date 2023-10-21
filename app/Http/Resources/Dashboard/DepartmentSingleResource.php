<?php

namespace App\Http\Resources\Dashboard;

use App\Models\PriceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DepartmentSingleResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'employees_count' => $this->employees_count,
            // 'employees_count' => $this->employees_minimum ?? [],
            // 'employees' => EmployeeMinimumResource::collection($this->employees_minimum) ?? [],
            'employees' => EmployeeListResource::collection($this->employees_minimum) ?? [],

        ];

        
    }
}
