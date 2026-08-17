<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
        'id'=>$this->id,

        'name'=>$this->name,

        'phone'=>$this->phone,

        'city'=>$this->city,

        'address'=>$this->address,

        'open_time'=>$this->open_time,

        'close_time'=>$this->close_time,

        'assignment' => $this->whenPivotLoaded('branch_employee', function () {
                return [
                    'is_primary' => $this->pivot->is_primary,

                    'assigned_at' => $this->pivot->assigned_at,
                ];
            }),

        'employees'=>EmployeeResource::collection(
            $this->whenLoaded('employees')
        ),
        ];
    }
    
}
