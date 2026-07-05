<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'id' => $this->id,

            'name' => $this->name,

            'phone' => $this->phone,

            'email' => $this->email,

            'description'=>$this->description,

            'branches'=>BranchResource::collection(
                $this->whenLoaded('branches')
            ),

            'employees'=>EmployeeResource::collection(
                $this->whenLoaded('employees')
            ),

            'categories'=>CategoryResource::collection( 
                $this->whenLoaded('categories') 
            ),
        ];
    }
}
