<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

            'employee_id'=>$this->employee_id,

            'username'=>$this->username,

            'is_active'=>$this->is_active,
            
            'last_login_at'=>$this->last_login_at,

            'roles'=>RoleResource::collection(
                $this->whenLoaded('roles')
            ),

             'employee' => $this->whenLoaded('employee', function () {
                return [
                    'id' => $this->employee->id,

                    'first_name' => $this->employee->first_name,

                    'last_name' => $this->employee->last_name,

                    'phone' => $this->employee->phone,

                    'email' => $this->employee->email,
                ];
            }),

        ];
    }
}
