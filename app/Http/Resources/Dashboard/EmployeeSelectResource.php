<?php

namespace App\Http\Resources\Dashboard;

use App\Models\PriceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id ,
            'name' => $this->name,
            'image' =>$this->image,
        ];

        
    }
}
