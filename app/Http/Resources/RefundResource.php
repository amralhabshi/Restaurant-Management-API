<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefundResource extends JsonResource
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

            'refund_number' => $this->refund_number,

            'amount' => $this->amount,

            'reason' => $this->reason,

            'notes' => $this->notes,

            'refunded_at' => $this->refunded_at,

            'invoice' => new InvoiceResource(
                $this->whenLoaded('invoice')
            ),

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

            'customer' => new CustomerResource(
                $this->whenLoaded('customer')
            ),

        ];
    }
}
