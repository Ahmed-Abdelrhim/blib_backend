<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EquipmentSingleResource extends JsonResource
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
            'company' => $this->company->name,
            'category' => $this->category->title,
            'serial_number' => $this->serial_number,
            'brand' => $this->brand,
            'model' => $this->model,
            'image' => $this->image,
            'in_use_by' => ($this->employee) ? $this->employee->name : null,
            'notes' => $this->notes,

        ];

        
    }
}
